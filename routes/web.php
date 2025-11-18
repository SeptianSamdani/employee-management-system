<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;

// redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    // GET menampilkan form login dan bernama 'login' sehingga auth middleware bisa redirect ke route('login')
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // POST menangani proses login (tidak harus bernama 'login')
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Employee Routes
    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', \App\Livewire\Employee\EmployeeList::class)->name('index')
            ->middleware('permission:view employees');
        Route::get('/create', \App\Livewire\Employee\EmployeeCreate::class)->name('create')
            ->middleware('permission:create employees');
        Route::get('/{employee}/edit', \App\Livewire\Employee\EmployeeEdit::class)->name('edit')
            ->middleware('permission:edit employees');
    });

    // Department Routes
    Route::prefix('departments')->name('departments.')->middleware('permission:manage departments')->group(function () {
        Route::get('/', \App\Livewire\Department\DepartmentManage::class)->name('index');
    });

    // Position Routes
    Route::prefix('positions')->name('positions.')->middleware('permission:manage departments')->group(function () {
        Route::get('/', \App\Livewire\Position\PositionManage::class)->name('index');
    });
    
    // Attendance Routes
    // Route::prefix('attendance')->name('attendance.')->group(function () {
    //     Route::get('/', \App\Livewire\Attendance\AttendanceList::class)->name('index')
    //         ->middleware('permission:view attendances');
    //     Route::get('/check-in', \App\Livewire\Attendance\AttendanceCheckIn::class)->name('check-in')
    //         ->middleware('permission:check in');
    // });
    
    // Leave Routes
    // Route::prefix('leaves')->name('leaves.')->group(function () {
    //     Route::get('/', \App\Livewire\Leave\LeaveList::class)->name('index')
    //         ->middleware('permission:view leaves');
    //     Route::get('/request', \App\Livewire\Leave\LeaveRequest::class)->name('request')
    //         ->middleware('permission:create leaves');
    //     Route::get('/approval', \App\Livewire\Leave\LeaveApproval::class)->name('approval')
    //         ->middleware('permission:approve leaves');
    // });
    
    // Payroll Routes (HR/Admin only)
    // Route::prefix('payroll')->name('payroll.')->middleware('role:admin|hr')->group(function () {
    //     Route::get('/', \App\Livewire\Payroll\PayrollList::class)->name('index');
    //     Route::get('/generate', \App\Livewire\Payroll\PayrollGenerate::class)->name('generate');
    // });
});