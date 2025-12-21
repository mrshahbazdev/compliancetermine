<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Category, Training};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    /**
     * Certificate ko Browser mein View karne ke liye (Download nahi)
     */
    public function viewCertificate(string $tenantId, Training $training)
    {
        $user = Auth::user();
        
        // Security Check: Kya user manager ya admin hai?
        if (!$user->isAdmin() && !$training->employee->responsibles->contains($user->id)) {
            abort(403);
        }

        if (!$training->certificate_path || !Storage::disk('public')->exists($training->certificate_path)) {
            abort(404, 'Zertifikat nicht gefunden.');
        }

        $path = Storage::disk('public')->path($training->certificate_path);
        $mimeType = Storage::disk('public')->mimeType($training->certificate_path);

        // 'inline' header file ko browser mein open karta hai
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"'
        ]);
    }

    /**
     * View: Employee ki trainings list
     */
    public function index(string $tenantId, string $employeeId)
    {
        $user = Auth::user();
        
        $employee = Employee::with(['trainings' => function($q) {
            $q->orderBy('expiry_date', 'desc');
        }, 'trainings.category'])->findOrFail($employeeId);

        // SECURITY CHECK
        if (!$user->isAdmin()) {
            $isAssigned = $employee->responsibles()->where('user_id', $user->id)->exists();
            if (!$isAssigned) {
                abort(403, 'Sie sind nicht für diesen Mitarbeiter verantwortlich.');
            }
        }

        // Data Fix: Ensure formatting works on existing records
        foreach($employee->trainings as $training) {
            // Hum hamesha last_event_date hi use karenge kyunki database mein wahi hai
            $training->training_date = $training->last_event_date;
        }

        $categories = Category::all();
        return view('tenant.trainings.index', compact('employee', 'categories'));
    }

    /**
     * Store: Nayi training save ya plan karna
     */
    public function store(Request $request, string $tenantId, string $employeeId)
{
    
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'last_event_date' => 'required|date', // Match with Blade
        'duration_days' => 'nullable|integer|min:1',
        'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
    ]);

    try {
        $trainingDate = \Carbon\Carbon::parse($request->last_event_date);
        
        $filePath = null;
        if ($request->hasFile('certificate')) {
            $filePath = $request->file('certificate')->store("tenants/{$tenantId}/certificates", 'public');
        }

        $status = $filePath ? 'completed' : 'planned';
        $days = (int) ($request->duration_days ?? 365); 
        $expiryDate = $trainingDate->copy()->addDays($days);

        // CREATE KI JAGAH SAVE METHOD USE KAREIN DEBUGGING KE LIYE
        $training = new \App\Models\Training();
        $training->employee_id = $employeeId;
        $training->category_id = $request->category_id;
        $training->last_event_date = $trainingDate;
        $training->expiry_date = $expiryDate;
        $training->duration_days = $days;
        $training->certificate_path = $filePath;
        $training->status = $status;
        
        $training->save(); // Agar yahan masla hoga toh catch block pakad lega

        return redirect()->back()->with('success', 'Gespeichert!');

    } catch (\Exception $e) {
        // AGAR KOI BHI ERROR AAYA TO YE SCREEN PAR SHOW HOGA
        dd("Database Error: " . $e->getMessage());
    }
}

    /**
     * Calendar View
     */
    public function calendar(string $tenantId)
    {
        $user = Auth::user();
        $query = Training::with(['employee', 'category']);

        if (!$user->isAdmin()) {
            $query->whereHas('employee.responsibles', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $trainings = $query->get();

        $events = $trainings->map(function ($training) {
            $isPlanned = $training->status === 'planned';
            $daysLeft = now()->diffInDays($training->expiry_date, false);

            if ($isPlanned) {
                $color = '#2563eb'; // Blue
                $statusText = 'Geplant';
            } else {
                $color = $daysLeft <= 90 ? '#ef4444' : '#10b981'; // Red or Emerald
                $statusText = $daysLeft < 0 ? 'Abgelaufen' : 'Gültig';
            }

            return [
                'title' => ($isPlanned ? '[P] ' : '') . $training->employee->name . ' - ' . $training->category->name,
                'start' => $training->expiry_date->format('Y-m-d'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'employee_name' => $training->employee->name,
                    'category' => $training->category->name,
                    'status' => $statusText,
                    'is_planned' => $isPlanned
                ]
            ];
        });

        return view('tenant.calendar.index', compact('events'));
    }
}