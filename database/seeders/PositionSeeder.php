<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Department;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            // IT
            ['name' => 'Software Engineer', 'code' => 'SE_ENGINEER', 'department_code' => 'IT', 'base_salary' => 8000000, 'description' => 'Pengembang perangkat lunak', 'is_active' => true],
            ['name' => 'System Administrator', 'code' => 'SYS_ADMIN', 'department_code' => 'IT', 'base_salary' => 7000000, 'description' => 'Pengelola infrastruktur TI', 'is_active' => true],
            ['name' => 'DevOps Engineer', 'code' => 'DEVOPS', 'department_code' => 'IT', 'base_salary' => 8500000, 'description' => 'Integrasi dan otomatisasi deployment', 'is_active' => true],

            // Finance
            ['name' => 'Accountant', 'code' => 'ACCOUNTANT', 'department_code' => 'FIN', 'base_salary' => 6500000, 'description' => 'Pembukuan dan laporan keuangan', 'is_active' => true],
            ['name' => 'Financial Analyst', 'code' => 'FIN_ANALYST', 'department_code' => 'FIN', 'base_salary' => 7500000, 'description' => 'Analisis keuangan dan forecasting', 'is_active' => true],

            // HR
            ['name' => 'HR Manager', 'code' => 'HR_MANAGER', 'department_code' => 'HR', 'base_salary' => 9000000, 'description' => 'Manajemen sumber daya manusia', 'is_active' => true],
            ['name' => 'Recruiter', 'code' => 'RECRUITER', 'department_code' => 'HR', 'base_salary' => 6000000, 'description' => 'Rekrutmen dan seleksi', 'is_active' => true],

            // Marketing
            ['name' => 'Marketing Manager', 'code' => 'MARKETING_MANAGER', 'department_code' => 'MKT', 'base_salary' => 8000000, 'description' => 'Strategi pemasaran dan kampanye', 'is_active' => true],
            ['name' => 'Content Strategist', 'code' => 'CONTENT_STRATEGIST', 'department_code' => 'MKT', 'base_salary' => 6000000, 'description' => 'Perencanaan konten pemasaran', 'is_active' => true],

            // Operations
            ['name' => 'Operations Manager', 'code' => 'OPS_MANAGER', 'department_code' => 'OPS', 'base_salary' => 8500000, 'description' => 'Pengelolaan operasional harian', 'is_active' => true],
            ['name' => 'Logistics Coordinator', 'code' => 'LOG_COORD', 'department_code' => 'OPS', 'base_salary' => 5500000, 'description' => 'Koordinasi logistik dan pengiriman', 'is_active' => true],
        ];

        foreach ($positions as $pos) {
            $departmentId = Department::where('code', $pos['department_code'])->value('id');

            if (! $departmentId) {
                // skip if department belum ada
                continue;
            }

            Position::updateOrCreate(
                ['code' => $pos['code']],
                [
                    'name' => $pos['name'],
                    'code' => $pos['code'],
                    'department_id' => $departmentId,
                    'base_salary' => $pos['base_salary'],
                    'description' => $pos['description'],
                    'is_active' => $pos['is_active'],
                ]
            );
        }
    }
}