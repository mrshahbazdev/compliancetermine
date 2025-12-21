<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Category, Training};
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrainingController extends Controller
{
    // Employee ki sab trainings dikhane ke liye
    public function index($tenantId, $employeeId)
    {
        $employee = Employee::with('trainings.category')->findOrFail($employeeId);
        $categories = Category::all();
        return view('tenant.trainings.index', compact('employee', 'categories'));
    }

    public function store(Request $request, $tenantId, $employeeId)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'last_event_date' => 'required|date',
            'duration_days' => 'required|integer|min:1',
        ]);

        // Expiry Date Calculate karna: Last Event + Duration
        $lastEvent = Carbon::parse($request->last_event_date);
        $expiryDate = $lastEvent->copy()->addDays($request->duration_days);

        Training::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'category_id' => $request->category_id,
            ],
            [
                'last_event_date' => $request->last_event_date,
                'duration_days' => $request->duration_days,
                'expiry_date' => $expiryDate,
            ]
        );

        return redirect()->back()->with('success', 'Schulungstermin wurde aktualisiert.');
    }
}