<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'name' => 'Cuti Tahunan',
                'code' => 'ANNUAL',
                'max_days' => 12,
                'is_paid' => true,
                'description' => 'Cuti tahunan yang diberikan kepada karyawan tetap',
                'is_active' => true,
            ],
            [
                'name' => 'Cuti Sakit',
                'code' => 'SICK',
                'max_days' => 14,
                'is_paid' => true,
                'description' => 'Cuti untuk kondisi sakit dengan surat dokter',
                'is_active' => true,
            ],
            [
                'name' => 'Cuti Menikah',
                'code' => 'MARRIAGE',
                'max_days' => 3,
                'is_paid' => true,
                'description' => 'Cuti untuk pernikahan karyawan',
                'is_active' => true,
            ],
            [
                'name' => 'Cuti Melahirkan',
                'code' => 'MATERNITY',
                'max_days' => 90,
                'is_paid' => true,
                'description' => 'Cuti melahirkan untuk karyawan wanita',
                'is_active' => true,
            ],
            [
                'name' => 'Cuti Orang Tua Meninggal',
                'code' => 'BEREAVEMENT',
                'max_days' => 2,
                'is_paid' => true,
                'description' => 'Cuti untuk kedukaan (orang tua/saudara kandung)',
                'is_active' => true,
            ],
            [
                'name' => 'Cuti Tanpa Gaji',
                'code' => 'UNPAID',
                'max_days' => 30,
                'is_paid' => false,
                'description' => 'Cuti tanpa dibayar',
                'is_active' => true,
            ],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create($type);
        }
    }
}