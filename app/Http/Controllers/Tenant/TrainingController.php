<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Category, Training};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
class TrainingController extends Controller
{
    

    public function viewCertificate(string $tenantId, Training $training)
    {
        // Security Check: Kya user ko is employee ka data dekhne ki ijazat hai?
        $user = auth()->user();
        if (!$user->isAdmin() && !$training->employee->responsibles->contains($user->id)) {
            abort(403);
        }

        if (!$training->certificate_path || !Storage::disk('public')->exists($training->certificate_path)) {
            abort(404, 'Zertifikat nicht gefunden.');
        }

        $path = Storage::disk('public')->path($training->certificate_path);
        $mimeType = Storage::disk('public')->mimeType($training->certificate_path);

        // 'inline' header file ko browser mein open karta hai (download nahi karta)
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"'
        ]);
    }
    /**
     * View: Employee ki trainings list aur naya plan karne ka form
     */
    public function index(string $tenantId, string $employeeId)
    {
        $user = Auth::user();
        
        // Employee with history fetch karein
        $employee = Employee::with(['trainings' => function($q) {
            $q->orderBy('expiry_date', 'desc');
        }, 'trainings.category'])->findOrFail($employeeId);

        // SECURITY CHECK: Manager access validation
        if (!$user->isAdmin()) {
            $isAssigned = $employee->responsibles()->where('user_id', $user->id)->exists();
            if (!$isAssigned) {
                abort(403, 'Sie sind nicht für diesen Mitarbeiter verantwortlich.');
            }
        }

        // DATA NORMALIZATION: Purane data ke liye fallback logic
        // Agar database mein training_date null hai, toh purana last_event_date use karein
        foreach($employee->trainings as $training) {
            if (!$training->training_date && $training->last_event_date) {
                $training->training_date = $training->last_event_date;
            }
        }

        $categories = Category::all();
        return view('tenant.trainings.index', compact('employee', 'categories'));
    }

    /**
     * Store: Nayi training schedule karna (Planned) ya complete karna (with Certificate)
     */
    public function store(Request $request, string $tenantId, string $employeeId)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'training_date' => 'required|date',
            'duration_days' => 'nullable|integer|min:1',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $category = Category::findOrFail($request->category_id);
        $trainingDate = \Carbon\Carbon::parse($request->training_date);
        
        // File Upload Logic
        $filePath = null;
        if ($request->hasFile('certificate')) {
            $filePath = $request->file('certificate')->store("tenants/{$tenantId}/certificates", 'public');
        }

        // Status: Certificate hai to completed, warna planned
        $status = $filePath ? 'completed' : 'planned';

        // FIX: Typecast to integer to avoid Carbon error
        $days = (int) ($request->duration_days ?? 365); 
        $expiryDate = $trainingDate->copy()->addDays($days);

        \App\Models\Training::create([
            'employee_id' => $employeeId,
            'category_id' => $request->category_id,
            'training_date' => $trainingDate,
            'expiry_date' => $expiryDate,
            'duration_days' => $days,
            'certificate_path' => $filePath,
            'status' => $status,
        ]);

        $msg = $status === 'planned' ? 'Schulung wurde erfolgreich geplant.' : 'Training und Zertifikat wurden gespeichert.';

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Calendar View: Logic for Red (Expiry) and Blue (Planned)
     */
    public function calendar(string $tenantId)
    {
        $user = Auth::user();
        $query = Training::with(['employee', 'category']);

        // Security: Manager sirf apne employees ke events dekhe
        if (!$user->isAdmin()) {
            $query->whereHas('employee.responsibles', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $trainings = $query->get();

        $events = $trainings->map(function ($training) {
            $isPlanned = $training->status === 'planned';
            $daysLeft = now()->diffInDays($training->expiry_date, false);

            // Color Logic
            if ($isPlanned) {
                $color = '#2563eb'; // Blue for Planned
                $statusText = 'Geplant';
            } else {
                $color = $daysLeft <= 90 ? '#ef4444' : '#10b981'; // Red for Critical, Emerald for OK
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