<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Welcome page - Public facing
Route::get('/', function () {
    return inertia('Welcome', [
        'laravelVersion' => app()->version(),
        'phpVersion' => PHP_VERSION,
    ]);
});

// Main Dashboard - After authentication
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// HRM Department Routes
Route::prefix('dashboard/hrm')->name('hrm.')->middleware(['auth', 'verified'])->group(function () {
    // HRM Staff Dashboard - Workforce Management
    Route::get('/employee', [DashboardController::class, 'hrmEmployee'])
        ->middleware(['role:HRM', 'position:staff'])
        ->name('employee.dashboard');

    // HRM Manager Dashboard - HR Analytics & Reports
    Route::get('/manager', [DashboardController::class, 'hrmManager'])
        ->middleware(['role:HRM', 'position:manager'])
        ->name('manager.dashboard');
});

// SCM Department Routes
Route::prefix('dashboard/scm')->name('scm.')->middleware(['auth', 'verified'])->group(function () {
    // SCM Staff Dashboard - Inventory & Logistics
    Route::get('/employee', [DashboardController::class, 'scmEmployee'])
        ->middleware(['role:SCM', 'position:staff'])
        ->name('employee.dashboard');

    // SCM Manager Dashboard - Supply Chain Analytics
    Route::get('/manager', [DashboardController::class, 'scmManager'])
        ->middleware(['role:SCM', 'position:manager'])
        ->name('manager.dashboard');
});

// Employee Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';
