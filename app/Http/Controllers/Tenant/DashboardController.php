<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Tenant, User, Employee, Category, Training};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(string $tenantId): View
    {
        $tenant = Tenant::findOrFail($tenantId);
        $user = Auth::user();

        // Check if user is admin/superuser
        if ($user->isAdmin()) {
            return $this->adminDashboard($tenant, $user);
        }

        // Regular responsible person dashboard
        return $this->userDashboard($tenant, $user);
    }

    /**
     * Admin Dashboard: Full Overview for the Tenant
     */
    private function adminDashboard(Tenant $tenant, User $user): View
    {
        // Statistics for the whole company
        $stats = [
            'total_employees'   => Employee::count(),
            'total_categories'  => Category::count(),
            'critical_trainings'=> Training::whereDate('expiry_date', '<=', now()->addDays(90))
                                           ->whereDate('expiry_date', '>=', now())
                                           ->count(),
            'total_certificates'=> Training::whereNotNull('certificate_path')->count(),
        ];

        // Next 10 upcoming or critical trainings
        $expiringTrainings = Training::with(['employee', 'category'])
            ->orderBy('expiry_date', 'asc')
            ->take(10)
            ->get();

        // List of admins/responsible persons
        $recentUsers = User::where('tenant_id', $tenant->id)
            ->latest()
            ->take(10)
            ->get();

        return view('tenant.dashboard.admin', compact(
            'tenant',
            'user',
            'stats',
            'expiringTrainings',
            'recentUsers'
        ));
    }

    /**
     * Regular Responsible Person Dashboard: Limited to their assigned employees
     */
    private function userDashboard(Tenant $tenant, User $user): View
    {
        // Get only employees assigned to this specific user
        $assignedEmployeeIds = $user->responsibleForEmployees()->pluck('employees.id');

        $stats = [
            'total_employees'   => $assignedEmployeeIds->count(),
            'critical_trainings'=> Training::whereIn('employee_id', $assignedEmployeeIds)
                                           ->whereDate('expiry_date', '<=', now()->addDays(90))
                                           ->count(),
            'total_certificates'=> Training::whereIn('employee_id', $assignedEmployeeIds)
                                           ->whereNotNull('certificate_path')
                                           ->count(),
        ];

        // Trainings only for their assigned employees
        $expiringTrainings = Training::with(['employee', 'category'])
            ->whereIn('employee_id', $assignedEmployeeIds)
            ->orderBy('expiry_date', 'asc')
            ->take(10)
            ->get();

        return view('tenant.dashboard.user', compact(
            'tenant',
            'user',
            'stats',
            'expiringTrainings'
        ));
    }
}