<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Tenant};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index(string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        
        // Sirf Admin hi dekh sakay
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // PURANI LOGIC KHATAM: teams, ideas, votes nikaal diye
        $users = User::where('tenant_id', $tenant->id)
            ->latest()
            ->get();

        $stats = [
            'total_users'  => $users->count(),
            'active_users' => $users->where('is_active', true)->count(),
            'admins'       => $users->where('role', 'admin')->count(),
            'standard'     => $users->where('role', 'standard')->count(),
        ];

        return view('tenant.admin.users.index', compact('users', 'stats', 'tenant'));
    }

    // Baaki methods (create, store, edit) ko bhi aise hi check karein 
    // ke wahan 'ideas' ya 'teams' ka koi zikr na ho.
}