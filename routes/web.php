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

// 1. Root / Welcome Page Logic
Route::get('/', function () {
    $tenant = request()->attributes->get('tenant');
    return view('welcome', [
        'tenant' => $tenant,
        'isGeneralLanding' => !$tenant
    ]);
})->name('home');

// 2. Authentication Routes (Global/Tenant Shared)
Route::middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// 3. Central Admin Routes (Tenant Management)
Route::middleware(['auth', 'admin.only'])->group(function () {
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
});

// 4. MAIN PROJECT ROUTES (Tenant Specific)
Route::prefix('tenant/{tenantId}')
    ->middleware(['identify.tenant', 'auth'])
    ->name('tenant.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- PHASE 2: Category Management ---
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        // --- PHASE 2: Employee Management ---
        Route::resource('employees', EmployeeController::class);

        // --- PHASE 3 & 4: Training & Certificates (Upcoming) ---
        Route::resource('trainings', TrainingController::class);
        Route::get('/calendar', [TrainingController::class, 'calendar'])->name('calendar');

        // --- Admin Specific within Tenant ---
        Route::middleware(['admin.only'])->prefix('admin')->name('admin.')->group(function () {
            
            // User Management
            Route::resource('users', UserManagementController::class);
            Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
            
            // Settings
            Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
            Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        });
    });