<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Helper function to filter employees based on role
     */
    private function getFilteredEmployeesQuery()
    {
        $user = Auth::user();
        $query = Employee::query();

        // Agar user admin NAHI hai, to sirf uske assigned employees filter karein
        if (!$user->isAdmin()) {
            $query->whereHas('responsibles', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

    public function index() {
        // Filtered query use kar rahe hain
        $employees = $this->getFilteredEmployeesQuery()->with('responsibles')->get();
        return view('tenant.employees.index', compact('employees'));
    }

    public function create() {
        // Sirf admin hi create kar sake (Security layer)
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Nur Administratoren können Mitarbeiter anlegen.');
        }
        
        $users = User::all(); 
        return view('tenant.employees.create', compact('users'));
    }

    public function show(string $tenantId, Employee $employee)
    {
        // Security check: Kya standard user is employee ko dekh sakta hai?
        if (!Auth::user()->isAdmin() && !$employee->responsibles->contains(Auth::id())) {
            abort(403);
        }

        $employee->load('trainings.category');
        return view('tenant.employees.show', compact('employee'));
    }

    public function store(Request $request) {
        if (!Auth::user()->isAdmin()) { abort(403); }

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

    public function edit(string $tenantId, Employee $employee) {
        if (!Auth::user()->isAdmin()) { abort(403); }

        $users = User::all();
        $selectedResponsibles = $employee->responsibles->pluck('id')->toArray();
        return view('tenant.employees.edit', compact('employee', 'users', 'selectedResponsibles'));
    }

    public function overview()
    {
        // Overview mein bhi wahi security filter lagega
        $employees = $this->getFilteredEmployeesQuery()->with('trainings.category')->get();

        // Categories ke liye filter: Sirf wo employees jo user ko assigned hain
        $user = Auth::user();
        $categories = Category::with(['trainings' => function($query) use ($user) {
            if (!$user->isAdmin()) {
                $query->whereHas('employee.responsibles', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
        }, 'trainings.employee'])->get();

        return view('tenant.employees.overview', compact('employees', 'categories'));
    }

    public function update(Request $request, string $tenantId, Employee $employee) {
        if (!Auth::user()->isAdmin()) { abort(403); }

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
        if (!Auth::user()->isAdmin()) { abort(403); }
        
        $employee->delete();
        return redirect()->route('tenant.employees.index', ['tenantId' => $tenantId])
                         ->with('success', 'Mitarbeiter gelöscht.');
    }
}