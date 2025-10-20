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

Route::get('/health', [DashboardController::class, 'health'])
    ->middleware(['auth', 'role:admin'])
    ->name('health');

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
    
    // Attendance routes
    // Employees (with permissions) can create/edit their own attendance
    Route::middleware(['permission:attendance.create'])->group(function () {
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });
    Route::middleware(['permission:attendance.edit'])->group(function () {
        Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit')->whereNumber('attendance');
        Route::match(['put', 'patch'], '/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update')->whereNumber('attendance');
    });

    // Admin/HR: index/show and bulk import
    Route::middleware(['role:admin,hr'])->group(function () {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show')->whereNumber('attendance');
        Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy')->whereNumber('attendance');
        Route::get('/attendance/bulk-import', [AttendanceController::class, 'bulkImport'])->name('attendance.bulk-import');
        Route::post('/attendance/bulk-import', [AttendanceController::class, 'processBulkImport'])->name('attendance.process-bulk-import');
    });

    // Employee self-service routes
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/my-profile', [EmployeeController::class, 'myProfile'])->name('my.profile');
        Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('my.attendance');
        Route::get('/my-employee/edit', [EmployeeController::class, 'editSelf'])->name('my.employee.edit');
        Route::match(['put','patch'], '/my-employee', [EmployeeController::class, 'updateSelf'])->name('my.employee.update');
    });
});

require __DIR__.'/auth.php';
