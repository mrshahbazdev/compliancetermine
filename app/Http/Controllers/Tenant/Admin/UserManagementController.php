<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Tenant};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // 1. List Users
    public function index(string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $users = User::where('tenant_id', $tenant->id)->latest()->get();

        $stats = [
            'total_users'  => $users->count(),
            'active_users' => $users->where('is_active', true)->count(),
            'admins'       => $users->where('role', 'admin')->count(),
            'standard'     => $users->where('role', 'standard')->count(),
        ];

        return view('tenant.admin.users.index', compact('users', 'stats', 'tenant'));
    }

    // 2. Show Create Form (YE MISSING THA)
    public function create(string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        return view('tenant.admin.users.create', compact('tenant'));
    }

    // 3. Store New User (YE MISSING THA)
    public function store(Request $request, string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,standard',
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('tenant.admin.users.index', $tenantId)
                         ->with('success', 'Benutzer wurde erfolgreich angelegt.');
    }

    // 4. Show Edit Form
    public function edit(string $tenantId, User $user)
    {
        $tenant = Tenant::findOrFail($tenantId);
        return view('tenant.admin.users.edit', compact('user', 'tenant'));
    }

    // 5. Update User
    public function update(Request $request, string $tenantId, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,standard',
            'password' => 'nullable|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->is_active = $request->has('is_active');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('tenant.admin.users.index', $tenantId)
                         ->with('success', 'Benutzer wurde erfolgreich aktualisiert.');
    }

    // 6. Delete User
    public function destroy(string $tenantId, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Sie können sich nicht selbst löschen.');
        }

        $user->delete();
        return redirect()->route('tenant.admin.users.index', $tenantId)
                         ->with('success', 'Benutzer gelöscht.');
    }

    // 7. Toggle Status
    public function toggleStatus(string $tenantId, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Status für eigenen Account kann nicht geändert werden.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status aktualisiert.');
    }
}