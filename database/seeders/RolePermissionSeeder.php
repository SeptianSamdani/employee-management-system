<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            // Employee
            'view employees',
            'create employees',
            'edit employees',
            'delete employees',
            
            // Department
            'view departments',
            'manage departments',
            
            // Position
            'manage positions',
            
            // Attendance
            'view attendances',
            'create attendances',
            'edit attendances',
            'check in',
            'check out',
            
            // Leave
            'view leaves',
            'create leaves',
            'approve leaves',
            'reject leaves',
            'manage leave types', // TAMBAHKAN INI
            
            // Work Schedule
            'manage work schedules',
            
            // Payroll
            'view payrolls',
            'generate payrolls',
            'finalize payrolls',
            
            // Reports
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $hr = Role::firstOrCreate(['name' => 'hr']);
        $hr->givePermissionTo([
            'view employees',
            'create employees',
            'edit employees',
            'view departments',
            'manage departments',
            'manage positions',
            'view attendances',
            'create attendances',
            'edit attendances',
            'view leaves',
            'create leaves',
            'approve leaves',
            'reject leaves',
            'manage leave types',
            'manage work schedules',
            'view payrolls',
            'generate payrolls',
            'finalize payrolls',
            'view reports',
        ]);

        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->givePermissionTo([
            'view employees',
            'view attendances',
            'view leaves',
            'approve leaves',
            'reject leaves',
            'view reports',
        ]);

        $employee = Role::firstOrCreate(['name' => 'employee']);
        $employee->givePermissionTo([
            'check in',
            'check out',
            'create leaves',
            'view leaves',
        ]);
    }
}