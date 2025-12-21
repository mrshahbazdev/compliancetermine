<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() {
        $employees = Employee::with('responsibles')->get();
        return view('tenant.employees.index', compact('employees'));
    }

    public function create() {
        // Sirf wo users dikhayen jo 'responsible' role ya relevant ho sakte hain
        $users = User::all(); 
        return view('tenant.employees.create', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'dob' => 'required|date',
            'responsible_ids' => 'required|array|min:1|max:3', // Max 3 responsible persons
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'dob' => $request->dob,
        ]);

        // Responsible persons ko link karna (Pivot table)
        $employee->responsibles()->sync($request->responsible_ids);

        return redirect()->route('tenant.employees.index')->with('success', 'Mitarbeiter angelegt.');
    }
}