<?php

// database/seeders/DepartmentSeeder.php
namespace Database\Seeders;

use App\Models\Department;
use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'IT', 'code' => 'IT', 'description' => 'Information Technology'],
            ['name' => 'Finance', 'code' => 'FIN', 'description' => 'Finance Department'],
            ['name' => 'HR', 'code' => 'HR', 'description' => 'Human Resources'],
            ['name' => 'Marketing', 'code' => 'MKT', 'description' => 'Marketing Department'],
            ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Operations'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Leave Types
        $leaveTypes = [
            ['name' => 'Cuti Tahunan', 'code' => 'ANNUAL', 'max_days' => 12, 'is_paid' => true],
            ['name' => 'Cuti Sakit', 'code' => 'SICK', 'max_days' => 14, 'is_paid' => true],
            ['name' => 'Cuti Menikah', 'code' => 'MARRIAGE', 'max_days' => 3, 'is_paid' => true],
            ['name' => 'Cuti Melahirkan', 'code' => 'MATERNITY', 'max_days' => 90, 'is_paid' => true],
            ['name' => 'Cuti Tanpa Gaji', 'code' => 'UNPAID', 'max_days' => 30, 'is_paid' => false],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create($type);
        }
    }
}