<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;

class AttendanceList extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFrom;
    public $dateTo;
    public $status = '';
    public $department_id = '';
    
    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $attendances = Attendance::query()
            ->with(['employee:id,employee_number,full_name,department_id', 'employee.department:id,name'])
            ->when($this->search, fn($q) => 
                $q->whereHas('employee', fn($q2) => 
                    $q2->where('full_name', 'like', "%{$this->search}%")
                        ->orWhere('employee_number', 'like', "%{$this->search}%")
                )
            )
            ->when($this->department_id, fn($q) =>
                $q->whereHas('employee', fn($q2) =>
                    $q2->where('department_id', $this->department_id)
                )
            )
            ->when($this->dateFrom, fn($q) => $q->where('date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->where('date', '<=', $this->dateTo))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->latest('date')
            ->paginate(20);
        
        $departments = Department::where('is_active', true)->get();
        
        return view('livewire.attendance.attendance-list', [
            'attendances' => $attendances,
            'departments' => $departments
        ]);
    }
    
    public function export()
    {
        return Excel::download(
            new AttendanceExport(
                $this->search,
                $this->dateFrom,
                $this->dateTo,
                $this->status,
                $this->department_id
            ),
            'attendance-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}