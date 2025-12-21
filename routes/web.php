<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Tenant\Auth\LoginController,
    Tenant\Auth\RegisterController,
    TenantController,
    HomeController
};
use App\Http\Controllers\Tenant\{
    DashboardController,
    CategoryController,
    EmployeeController,
    TrainingController
};
use App\Http\Controllers\Tenant\Admin\{
    UserManagementController,
    SettingsController
};
/*
|--------------------------------------------------------------------------
| Public Central Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $tenant = request()->attributes->get('tenant');
    return view('welcome', [
        'tenant' => $tenant,
        'isGeneralLanding' => !$tenant
    ]);
})->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('central.home');

/*
|--------------------------------------------------------------------------
| Tenant Routes (Prefix: tenant/{tenantId})
|--------------------------------------------------------------------------
*/
Route::prefix('tenant/{tenantId}')
    ->middleware(['identify.tenant'])
    ->name('tenant.') // Isse sare routes 'tenant.' se shuru honge (e.g. tenant.login)
    ->group(function () {

        // --- GUEST ROUTES (Login/Register) ---
        Route::middleware('guest')->group(function () {
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [LoginController::class, 'login'])->name('login.post');
            
            Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
            Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
        });

        // --- PROTECTED ROUTES (Requires Auth) ---
        Route::middleware(['auth'])->group(function () {
            
            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

            // PHASE 2: Category Management
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

            // PHASE 2: Employee Management
            Route::resource('employees', EmployeeController::class);

            // PHASE 3 & 4 (Upcoming): Trainings & Calendar
           // Phase 3: Trainings Management
            Route::get('/employees/{employee}/trainings', [TrainingController::class, 'index'])->name('trainings.employee.index');
            Route::post('/employees/{employee}/trainings', [TrainingController::class, 'store'])->name('trainings.store');
            Route::get('/calendar', [TrainingController::class, 'calendar'])->name('calendar');
            Route::get('/overview', [EmployeeController::class, 'overview'])->name('employees.overview');
            // --- TENANT ADMIN ROUTES ---
            Route::middleware(['admin.only'])->prefix('admin')->name('admin.')->group(function () {
                
                // User Management
                Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
                Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
                Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
                Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
                Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
                Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
                Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
                
                // Settings
                Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
                Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
            });
        });
    });

/*
|--------------------------------------------------------------------------
| Central Admin Management (Optional)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin.only'])->group(function () {
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
});