<?php

namespace Database\Seeders;

use App\Models\WorkSchedule;
use App\Models\Department;
use Illuminate\Database\Seeder;

class WorkScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();
        
        foreach ($departments as $dept) {
            WorkSchedule::updateOrCreate(
                ['department_id' => $dept->id],
                [
                    'check_in_start' => '08:00:00',
                    'check_in_end' => '09:00:00',
                    'check_out_start' => '17:00:00',
                    'check_out_end' => '18:00:00',
                    'late_tolerance_minutes' => 15,
                    'work_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']
                ]
            );
        }
    }
}