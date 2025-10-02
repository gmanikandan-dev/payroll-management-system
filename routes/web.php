<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard.view'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employee management routes - HR and Admin only
    Route::middleware(['role:admin,hr'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });
    
    // Department management routes - HR and Admin only
    Route::middleware(['role:admin,hr'])->group(function () {
        Route::resource('departments', DepartmentController::class);
    });
    
    // Payroll management routes - HR and Admin only
    Route::middleware(['role:admin,hr'])->group(function () {
        Route::resource('payrolls', PayrollController::class);
        Route::post('/payrolls/{payroll}/approve', [PayrollController::class, 'approve'])->name('payrolls.approve');
        Route::post('/payrolls/{payroll}/process', [PayrollController::class, 'process'])->name('payrolls.process');
    });
    
    // Attendance management routes
    Route::middleware(['role:admin,hr'])->group(function () {
        Route::resource('attendance', AttendanceController::class);
        Route::get('/attendance/bulk-import', [AttendanceController::class, 'bulkImport'])->name('attendance.bulk-import');
        Route::post('/attendance/bulk-import', [AttendanceController::class, 'processBulkImport'])->name('attendance.process-bulk-import');
    });

    // Employee self-service routes
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/my-profile', [EmployeeController::class, 'myProfile'])->name('my.profile');
        Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('my.attendance');
    });
});

require __DIR__.'/auth.php';
