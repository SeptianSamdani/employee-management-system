<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * URUTAN PENTING:
     * 1. RolePermissionSeeder - Buat roles & permissions dulu
     * 2. DepartmentSeeder - Buat departments
     * 3. PositionSeeder - Buat positions
     * 4. WorkScheduleSeeder - Buat jadwal kerja (butuh department)
     * 5. UserSeeder - Buat users & employees (butuh department, position)
     * 6. LeaveTypeSeeder - Buat tipe cuti
     */
    public function run(): void
    {
        $this->call([
            // 1. Roles & Permissions (tidak ada dependensi)
            RolePermissionSeeder::class,
            
            // 2. Master Data (tidak ada dependensi)
            DepartmentSeeder::class,
            PositionSeeder::class,
            LeaveTypeSeeder::class,
            
            // 3. Work Schedule (butuh Department)
            WorkScheduleSeeder::class,
            
            // 4. Users & Employees (butuh Department, Position, Roles)
            UserSeeder::class,
        ]);
    }
}