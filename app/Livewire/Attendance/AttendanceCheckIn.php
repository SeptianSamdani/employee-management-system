<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AttendanceCheckIn extends Component
{
    public $latitude;
    public $longitude;
    public $status = 'waiting';
    public $todayAttendance = null;
    public $schedule = null;
    
    public function mount()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            session()->flash('error', 'Data karyawan tidak ditemukan');
            return;
        }
        
        $this->schedule = $employee->department->workSchedule;
        $this->todayAttendance = Attendance::where('employee_id', $employee->id)
            ->where('date', today())
            ->first();
    }
    
    public function checkIn()
    {
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            $this->status = 'error';
            session()->flash('error', 'Data karyawan tidak ditemukan');
            return;
        }
        
        // Check if already checked in
        if ($this->todayAttendance) {
            $this->status = 'error';
            session()->flash('error', 'Anda sudah check-in hari ini');
            return;
        }
        
        $schedule = $employee->department->workSchedule;
        
        if (!$schedule) {
            $this->status = 'error';
            session()->flash('error', 'Jadwal kerja departemen belum diatur');
            return;
        }
        
        // Check if today is work day
        $today = strtolower(now()->format('l'));
        if (!in_array($today, $schedule->work_days)) {
            $this->status = 'error';
            session()->flash('error', 'Hari ini bukan hari kerja');
            return;
        }
        
        $now = now();
        $checkInTime = $now->format('H:i:s');
        
        // Calculate late
        $scheduledTime = Carbon::parse($schedule->check_in_end);
        $tolerance = Carbon::parse($schedule->check_in_end)->addMinutes($schedule->late_tolerance_minutes);
        
        $isLate = $now->greaterThan($tolerance);
        $lateMinutes = $isLate ? $now->diffInMinutes($scheduledTime) : 0;
        
        $this->todayAttendance = Attendance::create([
            'employee_id' => $employee->id,
            'date' => today(),
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
        
        if (!$this->todayAttendance) {
            $this->status = 'error';
            session()->flash('error', 'Anda belum check-in');
            return;
        }
        
        if ($this->todayAttendance->check_out) {
            $this->status = 'error';
            session()->flash('error', 'Anda sudah check-out');
            return;
        }
        
        $this->todayAttendance->update([
            'check_out' => now()->format('H:i:s'),
            'latitude_out' => $this->latitude,
            'longitude_out' => $this->longitude,
        ]);
        
        $this->status = 'success';
        session()->flash('message', 'Check-out berhasil!');
    }
    
    public function render()
    {
        return view('livewire.attendance.attendance-check-in');
    }
}