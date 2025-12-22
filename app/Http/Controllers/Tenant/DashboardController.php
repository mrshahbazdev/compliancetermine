<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Tenant, User, Employee, Category, Training};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(string $tenantId): View
    {
        $tenant = Tenant::findOrFail($tenantId);
        $user = Auth::user();

        // Admin dashboard full access ke liye
        if ($user->isAdmin()) {
            return $this->adminDashboard($tenant, $user);
        }

        // Regular user dashboard assigned employees ke liye
        return $this->userDashboard($tenant, $user);
    }

    /**
     * Admin Dashboard: Full Overview (Global Scopes will handle tenant isolation)
     */
    private function adminDashboard(Tenant $tenant, User $user): View
    {
        $today = Carbon::today();
        $warningDate = Carbon::today()->addDays(30);

        $stats = [
            'total_employees'   => Employee::count(),
            'expired'           => Training::where('expiry_date', '<', $today)
                                         ->where('status', 'completed')->count(),
            'warning'           => Training::whereBetween('expiry_date', [$today, $warningDate])
                                         ->where('status', 'completed')->count(),
            'planned'           => Training::where('status', 'planned')->count(),
            'total_certificates'=> Training::whereNotNull('certificate_path')->count(),
        ];

        // Top 10 Urgent Trainings across the company
        $expiringTrainings = Training::with(['employee', 'category'])
            ->where('status', 'completed')
            ->orderBy('expiry_date', 'asc')
            ->take(10)
            ->get();

        // Recent users (Managers) added in this tenant
        $recentUsers = User::where('tenant_id', $tenant->id)
            ->latest()
            ->take(5)
            ->get();

        return view('tenant.dashboard.admin', compact(
            'tenant', 'user', 'stats', 'expiringTrainings', 'recentUsers'
        ));
    }

    /**
     * User Dashboard: Limited to assigned employees
     */
    private function userDashboard(Tenant $tenant, User $user): View
    {
        $today = Carbon::today();
        $warningDate = Carbon::today()->addDays(30);

        // Get only IDs of employees this user is responsible for
        $assignedEmployeeIds = $user->responsibleForEmployees()->pluck('employees.id');

        $stats = [
            'total_employees'   => $assignedEmployeeIds->count(),
            'expired'           => Training::whereIn('employee_id', $assignedEmployeeIds)
                                         ->where('expiry_date', '<', $today)
                                         ->where('status', 'completed')->count(),
            'warning'           => Training::whereIn('employee_id', $assignedEmployeeIds)
                                         ->whereBetween('expiry_date', [$today, $warningDate])
                                         ->where('status', 'completed')->count(),
            'planned'           => Training::whereIn('employee_id', $assignedEmployeeIds)
                                         ->where('status', 'planned')->count(),
        ];

        // Urgent Trainings only for assigned employees
        $expiringTrainings = Training::with(['employee', 'category'])
            ->whereIn('employee_id', $assignedEmployeeIds)
            ->where('status', 'completed')
            ->orderBy('expiry_date', 'asc')
            ->take(10)
            ->get();

        return view('tenant.dashboard.user', compact(
            'tenant', 'user', 'stats', 'expiringTrainings'
        ));
    }
}