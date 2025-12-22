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
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Public Central Routes
|--------------------------------------------------------------------------
*/
Route::get('/test-email', function () {
    $targetEmail = 'mrshahbaznns@gmail.com';
    
    try {
        Mail::raw('Hallo Shahbaz! Der SMTP Server auf compliancetermine.de funktioniert einwandfrei.', function ($message) use ($targetEmail) {
            $message->to($targetEmail)
                    ->subject('SMTP Test - ComplianceTermine');
        });
        
        return "Email wurde erfolgreich an " . $targetEmail . " gesendet!";
    } catch (\Exception $e) {
        return "Fehler beim Versenden: " . $e->getMessage();
    }
});
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
    ->name('tenant.')
    ->group(function () {

        // --- GUEST ROUTES ---
        Route::middleware('guest')->group(function () {
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [LoginController::class, 'login'])->name('login.post');
            Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
            Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
        });

        // --- PROTECTED ROUTES (Admin & Standard User dono ke liye) ---
        Route::middleware(['auth'])->group(function () {
            
            // Dashboard & Auth
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

            // Overview & Matrix (Hamesha shared access)
            Route::get('/overview', [EmployeeController::class, 'overview'])->name('employees.overview');
            Route::get('/calendar', [TrainingController::class, 'calendar'])->name('calendar');
            Route::get('/certificates/view/{training}', [TrainingController::class, 'viewCertificate'])->name('certificates.view');
            // Employee Management (Standard User sirf assigned dekh sakega, Admin sab - Logic Controller mein handle hai)
            Route::resource('employees', EmployeeController::class);

            // Training Records
            Route::get('/employees/{employee}/trainings', [TrainingController::class, 'index'])->name('trainings.employee.index');
            Route::post('/employees/{employee}/trainings', [TrainingController::class, 'store'])->name('trainings.store');
            Route::get('/trainings/{training}/edit', [TrainingController::class, 'edit'])->name('trainings.edit');
            Route::put('/trainings/{training}', [TrainingController::class, 'update'])->name('trainings.update');
            // Category View (Standard User sirf dekh sakta hai)
            Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

            // --- ADMIN ONLY ROUTES ---
            Route::middleware(['admin.only'])->group(function () {
                
                // Full Category Management (Create/Delete sirf Admin)
                Route::resource('categories', CategoryController::class)->except(['show']);

                // Admin Prefix for System Settings
                Route::prefix('admin')->name('admin.')->group(function () {
                    
                    // User Management (Full CRUD)
                    Route::resource('users', UserManagementController::class);
                    Route::post('/users/{user}/toggle', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
                    
                    // Settings
                    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
                    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
                });
            });
        });
    });

/*
|--------------------------------------------------------------------------
| Central Admin Management
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin.only'])->group(function () {
    Route::resource('tenants', TenantController::class)->only(['index', 'create', 'store']);
});