<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan Department dan Position sudah ada
        $departments = Department::all();
        $positions = Position::all();

        if ($departments->isEmpty() || $positions->isEmpty()) {
            $this->command->error('❌ Departments atau Positions belum di-seed!');
            $this->command->info('Pastikan DepartmentSeeder dan PositionSeeder dijalankan terlebih dahulu.');
            return;
        }

        // Helper function untuk mendapatkan department ID
        $getDeptId = function($name) use ($departments) {
            return $departments->where('name', $name)->first()?->id 
                ?? $departments->first()->id;
        };

        // Helper function untuk mendapatkan position ID
        $getPosId = function($name) use ($positions) {
            return $positions->where('name', $name)->first()?->id 
                ?? $positions->first()->id;
        };

        // ============================================
        // 1. ADMIN USER (Tanpa Employee - System Admin)
        // ============================================
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // ============================================
        // 2. HR MANAGER
        // ============================================
        $hrManager = User::create([
            'name' => 'Dewi Sartika',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $hrManager->assignRole('hr');

        Employee::create([
            'user_id' => $hrManager->id,
            'employee_number' => 'EMP-001',
            'full_name' => 'Dewi Sartika',
            'email' => 'hr@example.com',
            'phone' => '081234567001',
            'date_of_birth' => '1985-03-15',
            'gender' => 'female',
            'address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
            'identity_number' => '3171234567890001',
            'department_id' => $getDeptId('Human Resources'),
            'position_id' => $getPosId('HR Manager'),
            'join_date' => '2020-01-15',
            'employment_status' => 'permanent',
            'status' => 'active',
        ]);

        // ============================================
        // 3. HR STAFF
        // ============================================
        $hrStaff = User::create([
            'name' => 'Rina Marlina',
            'email' => 'hr.staff@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $hrStaff->assignRole('hr');

        Employee::create([
            'user_id' => $hrStaff->id,
            'employee_number' => 'EMP-002',
            'full_name' => 'Rina Marlina',
            'email' => 'hr.staff@example.com',
            'phone' => '081234567002',
            'date_of_birth' => '1990-07-22',
            'gender' => 'female',
            'address' => 'Jl. Sudirman No. 25, Jakarta Selatan',
            'identity_number' => '3171234567890002',
            'department_id' => $getDeptId('Human Resources'),
            'position_id' => $getPosId('HR Staff'),
            'join_date' => '2021-06-01',
            'employment_status' => 'permanent',
            'status' => 'active',
        ]);

        // ============================================
        // 4. IT MANAGER
        // ============================================
        $itManager = User::create([
            'name' => 'Budi Santoso',
            'email' => 'it.manager@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $itManager->assignRole('manager');

        Employee::create([
            'user_id' => $itManager->id,
            'employee_number' => 'EMP-003',
            'full_name' => 'Budi Santoso',
            'email' => 'it.manager@example.com',
            'phone' => '081234567003',
            'date_of_birth' => '1982-11-08',
            'gender' => 'male',
            'address' => 'Jl. Gatot Subroto No. 50, Jakarta Selatan',
            'identity_number' => '3171234567890003',
            'department_id' => $getDeptId('IT'),
            'position_id' => $getPosId('IT Manager'),
            'join_date' => '2019-03-01',
            'employment_status' => 'permanent',
            'status' => 'active',
        ]);

        // ============================================
        // 5. FINANCE MANAGER
        // ============================================
        $financeManager = User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'finance.manager@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $financeManager->assignRole('manager');

        Employee::create([
            'user_id' => $financeManager->id,
            'employee_number' => 'EMP-004',
            'full_name' => 'Ahmad Wijaya',
            'email' => 'finance.manager@example.com',
            'phone' => '081234567004',
            'date_of_birth' => '1980-05-20',
            'gender' => 'male',
            'address' => 'Jl. Kuningan No. 15, Jakarta Selatan',
            'identity_number' => '3171234567890004',
            'department_id' => $getDeptId('Finance'),
            'position_id' => $getPosId('Finance Manager'),
            'join_date' => '2018-08-15',
            'employment_status' => 'permanent',
            'status' => 'active',
        ]);

        // ============================================
        // 6. IT EMPLOYEE - Senior Developer
        // ============================================
        $itSenior = User::create([
            'name' => 'Dimas Pratama',
            'email' => 'dimas@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $itSenior->assignRole('employee');

        Employee::create([
            'user_id' => $itSenior->id,
            'employee_number' => 'EMP-005',
            'full_name' => 'Dimas Pratama',
            'email' => 'dimas@example.com',
            'phone' => '081234567005',
            'date_of_birth' => '1992-09-12',
            'gender' => 'male',
            'address' => 'Jl. Kemang Raya No. 88, Jakarta Selatan',
            'identity_number' => '3171234567890005',
            'department_id' => $getDeptId('IT'),
            'position_id' => $getPosId('Senior Developer'),
            'join_date' => '2021-02-01',
            'employment_status' => 'permanent',
            'status' => 'active',
        ]);

        // ============================================
        // 7. IT EMPLOYEE - Junior Developer
        // ============================================
        $itJunior = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $itJunior->assignRole('employee');

        Employee::create([
            'user_id' => $itJunior->id,
            'employee_number' => 'EMP-006',
            'full_name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'phone' => '081234567006',
            'date_of_birth' => '1998-04-25',
            'gender' => 'female',
            'address' => 'Jl. Tebet Raya No. 30, Jakarta Selatan',
            'identity_number' => '3171234567890006',
            'department_id' => $getDeptId('IT'),
            'position_id' => $getPosId('Junior Developer'),
            'join_date' => '2023-07-01',
            'employment_status' => 'contract',
            'status' => 'active',
        ]);

        // ============================================
        // 8. FINANCE EMPLOYEE - Accountant
        // ============================================
        $accountant = User::create([
            'name' => 'Ratna Dewi',
            'email' => 'ratna@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $accountant->assignRole('employee');

        Employee::create([
            'user_id' => $accountant->id,
            'employee_number' => 'EMP-007',
            'full_name' => 'Ratna Dewi',
            'email' => 'ratna@example.com',
            'phone' => '081234567007',
            'date_of_birth' => '1991-12-03',
            'gender' => 'female',
            'address' => 'Jl. Pancoran No. 45, Jakarta Selatan',
            'identity_number' => '3171234567890007',
            'department_id' => $getDeptId('Finance'),
            'position_id' => $getPosId('Accountant'),
            'join_date' => '2022-01-15',
            'employment_status' => 'permanent',
            'status' => 'active',
        ]);

        // ============================================
        // 9. MARKETING EMPLOYEE
        // ============================================
        $marketing = User::create([
            'name' => 'Hendro Wibowo',
            'email' => 'hendro@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $marketing->assignRole('employee');

        Employee::create([
            'user_id' => $marketing->id,
            'employee_number' => 'EMP-008',
            'full_name' => 'Hendro Wibowo',
            'email' => 'hendro@example.com',
            'phone' => '081234567008',
            'date_of_birth' => '1993-06-18',
            'gender' => 'male',
            'address' => 'Jl. Senayan No. 20, Jakarta Selatan',
            'identity_number' => '3171234567890008',
            'department_id' => $getDeptId('Marketing'),
            'position_id' => $getPosId('Marketing Staff'),
            'join_date' => '2022-09-01',
            'employment_status' => 'permanent',
            'status' => 'active',
        ]);

        // ============================================
        // 10. INTERN/PROBATION EMPLOYEE
        // ============================================
        $intern = User::create([
            'name' => 'Fajar Nugroho',
            'email' => 'fajar@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $intern->assignRole('employee');

        Employee::create([
            'user_id' => $intern->id,
            'employee_number' => 'EMP-009',
            'full_name' => 'Fajar Nugroho',
            'email' => 'fajar@example.com',
            'phone' => '081234567009',
            'date_of_birth' => '2000-01-10',
            'gender' => 'male',
            'address' => 'Jl. Cikini No. 12, Jakarta Pusat',
            'identity_number' => '3171234567890009',
            'department_id' => $getDeptId('IT'),
            'position_id' => $getPosId('Intern'),
            'join_date' => '2024-01-02',
            'employment_status' => 'internship',
            'status' => 'active',
        ]);

        $this->command->info('');
        $this->command->info('✅ 10 Users dengan berbagai role berhasil dibuat!');
        $this->command->table(
            ['Email', 'Role', 'Password'],
            [
                ['admin@example.com', 'admin', 'password'],
                ['hr@example.com', 'hr', 'password'],
                ['hr.staff@example.com', 'hr', 'password'],
                ['it.manager@example.com', 'manager', 'password'],
                ['finance.manager@example.com', 'manager', 'password'],
                ['dimas@example.com', 'employee', 'password'],
                ['siti@example.com', 'employee', 'password'],
                ['ratna@example.com', 'employee', 'password'],
                ['hendro@example.com', 'employee', 'password'],
                ['fajar@example.com', 'employee', 'password'],
            ]
        );
    }
}