<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Category, Training};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * View: Employee ki trainings list aur naya plan karne ka form
     */
    public function index(string $tenantId, string $employeeId)
    {
        $user = Auth::user();
        
        // Employee with history
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
        $trainingDate = Carbon::parse($request->training_date);
        
        // File Upload Logic
        $filePath = null;
        if ($request->hasFile('certificate')) {
            $filePath = $request->file('certificate')->store("tenants/{$tenantId}/certificates", 'public');
        }

        // Logic: Agar certificate hai toh 'completed', warna 'planned'
        $status = $filePath ? 'completed' : 'planned';

        // Expiry Calculation
        // Agar duration_days form se nahi aaye, toh Category ki default validity use karein (agar model mein ho)
        $days = $request->duration_days ?? 365; 
        $expiryDate = $trainingDate->copy()->addDays($days);

        Training::create([
            'employee_id' => $employeeId,
            'category_id' => $request->category_id,
            'training_date' => $trainingDate, // last_event_date ki jagah training_date use karein
            'expiry_date' => $expiryDate,
            'duration_days' => $days,
            'certificate_path' => $filePath,
            'status' => $status, // 'completed' or 'planned'
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