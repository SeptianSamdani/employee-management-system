<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AttendanceHistory extends Component
{
    use WithPagination;

    public $month;
    public $year;
    
    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
    }
    
    public function updatedMonth()
    {
        $this->resetPage();
    }
    
    public function updatedYear()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $employee = Auth::user()->employee;
        
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        $stats = [
            'total_days' => $attendances->total(),
            'present' => Attendance::where('employee_id', $employee->id)
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->where('status', 'present')
                ->count(),
            'late' => Attendance::where('employee_id', $employee->id)
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->where('status', 'late')
                ->count(),
            'absent' => Attendance::where('employee_id', $employee->id)
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->where('status', 'absent')
                ->count(),
        ];
        
        return view('livewire.attendance.attendance-history', [
            'attendances' => $attendances,
            'stats' => $stats
        ]);
    }
}