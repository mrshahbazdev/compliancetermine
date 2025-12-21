<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Category; 
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() {
        $employees = Employee::with('responsibles')->get();
        return view('tenant.employees.index', compact('employees'));
    }

    public function create() {
        $users = User::all(); 
        return view('tenant.employees.create', compact('users'));
    }
    public function show(string $tenantId, Employee $employee)
    {
        // Employee ke sath unki sari trainings aur categories fetch karein
        $employee->load('trainings.category');
        return view('tenant.employees.show', compact('employee'));
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'dob' => 'required|date',
            'responsible_ids' => 'required|array|min:1|max:3',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'dob' => $request->dob,
        ]);

        $employee->responsibles()->sync($request->responsible_ids);

        return redirect()->route('tenant.employees.index', ['tenantId' => request()->route('tenantId')])
                         ->with('success', 'Mitarbeiter angelegt.');
    }

    // --- YE METHODS ADD KAREIN ---

    public function edit(string $tenantId, Employee $employee) {
        $users = User::all();
        $selectedResponsibles = $employee->responsibles->pluck('id')->toArray();
        return view('tenant.employees.edit', compact('employee', 'users', 'selectedResponsibles'));
    }
    public function overview()
    {
        // 1. Employee focused: Har employee ke sath uski trainings fetch karein
        $employees = Employee::with('trainings.category')->get();

        // 2. Category focused: Har category ke sath uske employees fetch karein
        $categories = Category::with('trainings.employee')->get();

        return view('tenant.employees.overview', compact('employees', 'categories'));
    }
    public function update(Request $request, string $tenantId, Employee $employee) {
        $request->validate([
            'name' => 'required|string',
            'dob' => 'required|date',
            'responsible_ids' => 'required|array|min:1|max:3',
        ]);

        $employee->update([
            'name' => $request->name,
            'dob' => $request->dob,
        ]);

        $employee->responsibles()->sync($request->responsible_ids);

        return redirect()->route('tenant.employees.index', ['tenantId' => $tenantId])
                         ->with('success', 'Mitarbeiter aktualisiert.');
    }

    public function destroy(string $tenantId, Employee $employee) {
        $employee->delete(); // Pivot table entry automatically delete ho jayegi cascade se
        return redirect()->route('tenant.employees.index', ['tenantId' => $tenantId])
                         ->with('success', 'Mitarbeiter gelöscht.');
    }
}