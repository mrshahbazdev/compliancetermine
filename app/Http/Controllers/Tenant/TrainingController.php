<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Category, Training};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail; // Email support ke liye
use App\Mail\TrainingPlannedNotification; // Mail class

class TrainingController extends Controller
{
    /**
     * Certificate ko Browser mein View karne ke liye
     */
    public function viewCertificate(string $tenantId, Training $training)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$training->employee->responsibles->contains($user->id)) {
            abort(403);
        }

        if (!$training->certificate_path || !Storage::disk('public')->exists($training->certificate_path)) {
            abort(404, 'Zertifikat nicht gefunden.');
        }

        $path = Storage::disk('public')->path($training->certificate_path);
        $mimeType = Storage::disk('public')->mimeType($training->certificate_path);

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

        if (!$user->isAdmin()) {
            $isAssigned = $employee->responsibles()->where('user_id', $user->id)->exists();
            if (!$isAssigned) {
                abort(403, 'Sie sind nicht für diesen Mitarbeiter verantwortlich.');
            }
        }

        foreach($employee->trainings as $training) {
            $training->training_date = $training->last_event_date;
        }

        $categories = Category::all();
        return view('tenant.trainings.index', compact('employee', 'categories'));
    }

    /**
     * Store: Training save karna aur Manager ko Email bhejna
     */
    public function store(Request $request, string $tenantId, string $employeeId)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'last_event_date' => 'required|date',
            'duration_days' => 'nullable|integer|min:1',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480',
        ]);

        try {
            $employee = Employee::findOrFail($employeeId);
            $trainingDate = Carbon::parse($request->last_event_date);
            
            $filePath = null;
            if ($request->hasFile('certificate')) {
                $filePath = $request->file('certificate')->store("tenants/{$tenantId}/certificates", 'public');
            }

            $status = $filePath ? 'completed' : 'planned';
            $days = (int) ($request->duration_days ?? 365); 
            $expiryDate = $trainingDate->copy()->addDays($days);

            // Training Create
            $training = new Training();
            $training->employee_id = $employeeId;
            $training->category_id = $request->category_id;
            $training->last_event_date = $trainingDate;
            $training->expiry_date = $expiryDate;
            $training->duration_days = $days;
            $training->certificate_path = $filePath;
            $training->status = $status;
            $training->save();

            // TRIGGER EMAIL: Agar training plan hui hai, toh managers ko notify karein
            if ($status === 'planned') {
                $managers = $employee->responsibles; // Responsible users (Managers)
                foreach ($managers as $manager) {
                    Mail::to($manager->email)->send(new TrainingPlannedNotification($training));
                }
            }

            $msg = $status === 'planned' ? 'Schulung geplant und Manager benachrichtigt!' : 'Gespeichert!';
            return redirect()->back()->with('success', $msg);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Fehler: ' . $e->getMessage()]);
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
    // Edit Form dikhane ke liye
    public function edit(string $tenantId, Training $training)
    {
        $categories = Category::all();
        return view('tenant.trainings.edit', compact('training', 'categories'));
    }

    // Data update karne ke liye
    public function update(Request $request, string $tenantId, Training $training)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'last_event_date' => 'required|date',
            'duration_days' => 'nullable|integer|min:1',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480',
        ]);

        $trainingDate = \Carbon\Carbon::parse($request->last_event_date);
        $days = (int) ($request->duration_days ?? 365);

        // File Handling
        if ($request->hasFile('certificate')) {
            // Purani file delete karein agar maujood hai
            if ($training->certificate_path) {
                \Storage::disk('public')->delete($training->certificate_path);
            }
            $training->certificate_path = $request->file('certificate')->store("tenants/{$tenantId}/certificates", 'public');
            $training->status = 'completed'; // Certificate aane par status complete
        }

        $training->category_id = $request->category_id;
        $training->last_event_date = $trainingDate;
        $training->expiry_date = $trainingDate->copy()->addDays($days);
        $training->duration_days = $days;
        $training->save();

        return redirect()->route('tenant.trainings.index', [$tenantId, $training->employee_id])
                        ->with('success', 'Eintrag erfolgreich aktualisiert!');
    }
    public function destroy(string $tenantId, Training $training)
    {
        if ($training->certificate_path) {
            \Storage::disk('public')->delete($training->certificate_path);
        }
        $training->delete();
        return redirect()->back()->with('success', 'Eintrag gelöscht!');
    }
}