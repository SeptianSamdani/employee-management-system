<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // HR User
        $hr = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $hr->assignRole('hr');

        // Manager User
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $manager->assignRole('manager');

        // Employee User
        $employee = User::create([
            'name' => 'Employee',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $employee->assignRole('employee');
    }
}