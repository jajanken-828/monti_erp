<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\hrm\employee\AttendanceController;
use App\Http\Controllers\hrm\employee\InterviewController;
use App\Http\Controllers\hrm\employee\LeaveController;
use App\Http\Controllers\hrm\employee\TrainingController;
use App\Http\Controllers\hrm\manager\AnalyticsController;
use App\Http\Controllers\hrm\manager\ApplicantController;
use App\Http\Controllers\hrm\manager\OnboardingController;
use App\Http\Controllers\hrm\manager\PayrollController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return inertia('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => app()->version(),
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth'])->group(function () {
    // The main entry point that redirects based on user role/position
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

/*
|--------------------------------------------------------------------------
| HRM Department Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard/hrm')->name('hrm.')->middleware(['auth', 'verified'])->group(function () {

    // Pointing to consolidated index logic for HRM Staff
    Route::get('/employee', [DashboardController::class, 'index'])
        ->middleware(['role:HRM', 'position:staff'])
        ->name('employee.dashboard');

    Route::get('/training', [TrainingController::class, 'training'])
        ->middleware(['role:HRM', 'position:staff'])
        ->name('employee.training');

    Route::get('/leave', [LeaveController::class, 'leave'])
        ->middleware(['role:HRM', 'position:staff'])
        ->name('employee.leave');

    Route::get('/attendance', [AttendanceController::class, 'attendance'])
        ->middleware(['role:HRM', 'position:staff'])
        ->name('employee.attendance');

    Route::get('/interview', [InterviewController::class, 'interview'])
        ->middleware(['role:HRM', 'position:staff'])
        ->name('employee.interview');

    // Pointing to consolidated index logic for HRM Manager
    Route::get('/manager', [DashboardController::class, 'index'])
        ->middleware(['role:HRM', 'position:manager'])
        ->name('manager.dashboard');

    Route::get('/applicants', [ApplicantController::class, 'index'])
        ->middleware(['role:HRM', 'position:manager,staff'])
        ->name('applicants.index');

    Route::get('/onboarding', [OnboardingController::class, 'onboarding'])
        ->middleware(['role:HRM', 'position:manager'])
        ->name('manager.onboarding');

    Route::get('/payroll', [PayrollController::class, 'payroll'])
        ->middleware(['role:HRM', 'position:manager'])
        ->name('manager.payroll');

    Route::get('/analytics', [AnalyticsController::class, 'analytics'])
        ->middleware(['role:HRM', 'position:manager'])
        ->name('manager.analytics');
});

/*
|--------------------------------------------------------------------------
| SCM Department Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard/scm')->name('scm.')->middleware(['auth', 'verified'])->group(function () {

    // Removed ScmdashboardController and pointed to consolidated DashboardController
    Route::get('/manager', [DashboardController::class, 'index'])
        ->middleware(['role:SCM', 'position:manager'])
        ->name('manager.dashboard');

    // Example route for SCM staff if needed
    Route::get('/staff', [DashboardController::class, 'index'])
        ->middleware(['role:SCM', 'position:staff'])
        ->name('staff.dashboard');
});

require __DIR__.'/auth.php';
