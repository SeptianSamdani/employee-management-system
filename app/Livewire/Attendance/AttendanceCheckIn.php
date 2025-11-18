<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AttendanceCheckIn extends Component
{
    public $latitude;
    public $longitude;
    public $status = 'waiting'; // waiting, success, error
    
    public function checkIn()
    {
        $employee = Auth::user()->employee;
        $today = today();
        
        // Check if already checked in
        if (Attendance::where('employee_id', $employee->id)->where('date', $today)->exists()) {
            $this->status = 'error';
            session()->flash('error', 'Anda sudah check-in hari ini');
            return;
        }
        
        $schedule = $employee->department->workSchedule;
        $now = now();
        $checkInTime = $now->format('H:i:s');
        
        // Calculate late
        $scheduledTime = Carbon::parse($schedule->check_in_end);
        $isLate = $now->greaterThan($scheduledTime);
        $lateMinutes = $isLate ? $now->diffInMinutes($scheduledTime) : 0;
        
        Attendance::create([
            'employee_id' => $employee->id,
            'date' => $today,
            'check_in' => $checkInTime,
            'scheduled_in' => $schedule->check_in_start,
            'scheduled_out' => $schedule->check_out_start,
            'status' => $isLate ? 'late' : 'present',
            'is_late' => $isLate,
            'late_minutes' => $lateMinutes,
            'latitude_in' => $this->latitude,
            'longitude_in' => $this->longitude,
        ]);
        
        $this->status = 'success';
        session()->flash('message', 'Check-in berhasil!');
    }
    
    public function checkOut()
    {
        $employee = Auth::user()->employee;
        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('date', today())
                                ->first();
        
        if (!$attendance) {
            session()->flash('error', 'Anda belum check-in');
            return;
        }
        
        if ($attendance->check_out) {
            session()->flash('error', 'Anda sudah check-out');
            return;
        }
        
        $attendance->update([
            'check_out' => now()->format('H:i:s'),
            'latitude_out' => $this->latitude,
            'longitude_out' => $this->longitude,
        ]);
        
        session()->flash('message', 'Check-out berhasil!');
    }
}