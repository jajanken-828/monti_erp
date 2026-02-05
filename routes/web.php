<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\hrm\manager\ApplicantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Public Routes
Route::get('/', function () {
    return inertia('Welcome', [
        'canLogin' => true,
        'canRegister' => true,
        'laravelVersion' => app()->version(),
        'phpVersion' => PHP_VERSION,
    ]);
});

// 2. Authenticated General Routes
Route::middleware(['auth'])->group(function () {

    // Main Entry Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| HRM Department Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard/hrm')->name('hrm.')->middleware(['auth', 'verified'])->group(function () {

    // Staff Dashboard
    Route::get('/employee', [DashboardController::class, 'hrmEmployee'])
        ->middleware(['role:HRM', 'position:staff'])
        ->name('employee.dashboard');

    // Manager Dashboard (Analytics)
    Route::get('/manager', [DashboardController::class, 'hrmManager'])
        ->middleware(['role:HRM', 'position:manager'])
        ->name('manager.dashboard');

    // Recruitment / Applicants Portal
    // This matches the route('hrm.applicants.index') call in your Sidebar
    Route::get('/applicants', [ApplicantController::class, 'index'])
        ->middleware(['role:HRM', 'position:manager'])
        ->name('applicants.index');
});

/*
|--------------------------------------------------------------------------
| SCM Department Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard/scm')->name('scm.')->middleware(['auth', 'verified'])->group(function () {

    // SCM Staff Dashboard
    Route::get('/employee', [DashboardController::class, 'scmEmployee'])
        ->middleware(['role:SCM', 'position:staff'])
        ->name('employee.dashboard');

    // SCM Manager Dashboard
    Route::get('/manager', [DashboardController::class, 'scmManager'])
        ->middleware(['role:SCM', 'position:manager'])
        ->name('manager.dashboard');
});

// 3. Authentication Routes (Laravel Breeze/Jetstream)
require __DIR__.'/auth.php';
