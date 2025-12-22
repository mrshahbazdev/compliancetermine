<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\LegalController;
use App\Http\Controllers\Tenant\{DashboardController, UpgradeController};
use App\Http\Controllers\Tenant\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'tenant.check'
])->group(function () {

    // 1. PUBLIC LEGAL ROUTES (Sab ke liye, bina login ke bhi)
    // Inhein 'tenant.' prefix ke andar hona chahiye taake parameter missing na ho
    Route::name('tenant.legal.')->group(function () {
        Route::get('/impressum', [LegalController::class, 'impressum'])->name('impressum');
        Route::get('/datenschutz', [LegalController::class, 'datenschutz'])->name('datenschutz');
        Route::get('/nutzungsbedingungen', [LegalController::class, 'terms'])->name('terms');
    });

    // 2. TENANT CHECK MIDDLEWARE GROUP
    Route::middleware(['tenant.check'])->group(function () {
        
        // Upgrade page (subscription expired)
        Route::get('/upgrade', [UpgradeController::class, 'index'])
            ->name('tenant.upgrade')
            ->withoutMiddleware('tenant.check');
        
        // Auth routes
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('tenant.login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LoginController::class, 'logout'])->name('tenant.logout');
        
        // 3. PROTECTED ROUTES (Login required)
        Route::middleware('auth')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('tenant.dashboard');
            
            // Yahan aapke baaki resources aayenge:
            // Route::resource('employees', EmployeeController::class);
        });
    });
});