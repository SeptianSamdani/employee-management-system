<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

// redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
    // Dashboard (Livewire Component)
    Route::get('/dashboard', \App\Livewire\Dashboard\DashboardIndex::class)->name('dashboard');
    
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
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', \App\Livewire\Attendance\AttendanceList::class)->name('index')
            ->middleware('permission:view attendances');
        Route::get('/check-in', \App\Livewire\Attendance\AttendanceCheckIn::class)->name('check-in')
            ->middleware('permission:check in');
        Route::get('/history', \App\Livewire\Attendance\AttendanceHistory::class)->name('history')
            ->middleware('auth');
    });

    // Work Schedule Routes (Admin/HR only)
    Route::prefix('work-schedules')->name('work-schedules.')->middleware('role:admin|hr')->group(function () {
        Route::get('/', \App\Livewire\WorkSchedule\WorkScheduleManage::class)->name('index');
    });
});