<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class AttendanceList extends Component
{
    public $search = '';
    public $dateFrom;
    public $dateTo;
    public $status = '';
    
    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }
    
    public function render()
    {
        $attendances = Attendance::query()
            ->with(['employee:id,employee_number,full_name,department_id'])
            ->when($this->search, fn($q) => 
                $q->whereHas('employee', fn($q2) => 
                    $q2->where('full_name', 'like', "%{$this->search}%")
                )
            )
            ->when($this->dateFrom, fn($q) => $q->where('date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->where('date', '<=', $this->dateTo))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->latest('date')
            ->paginate(20);
        
        return view('livewire.attendance.attendance-list', compact('attendances'));
    }
    
    public function export()
    {
        // Will implement in Step 5
    }
}
