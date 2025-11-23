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
    }
}