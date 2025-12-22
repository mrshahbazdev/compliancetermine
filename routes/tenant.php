<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\LegalController;
use App\Http\Controllers\Tenant\{DashboardController, UpgradeController};
use App\Http\Controllers\Tenant\Auth\LoginController;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // 1. PUBLIC LEGAL ROUTES (Bina login aur bina tenant.check ke)
    Route::name('tenant.legal.')->group(function () {
        Route::get('/impressum', [LegalController::class, 'impressum'])->name('impressum');
        Route::get('/datenschutz', [LegalController::class, 'datenschutz'])->name('datenschutz');
        Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
    });

    // 2. TENANT CHECK MIDDLEWARE GROUP (Sirf Dashboard aur Auth ke liye)
    Route::middleware(['tenant.check'])->group(function () {
        
        // Upgrade page
        Route::get('/upgrade', [UpgradeController::class, 'index'])
            ->name('tenant.upgrade')
            ->withoutMiddleware('tenant.check');
        
        // Auth routes
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('tenant.login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LoginController::class, 'logout'])->name('tenant.logout');
        
        // 3. PROTECTED ROUTES
        Route::middleware('auth')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('tenant.dashboard');
            // Route::resource('employees', EmployeeController::class);
        });
    });
});