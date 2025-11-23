<?php

namespace App\Livewire\WorkSchedule;

use App\Models\WorkSchedule;
use App\Models\Department;
use Livewire\Component;

class WorkScheduleManage extends Component
{
    public $departments;
    public $selectedDepartment;
    public $schedule;
    
    public $check_in_start;
    public $check_in_end;
    public $check_out_start;
    public $check_out_end;
    public $late_tolerance_minutes;
    public $work_days = [];
    
    protected $rules = [
        'check_in_start' => 'required',
        'check_in_end' => 'required',
        'check_out_start' => 'required',
        'check_out_end' => 'required',
        'late_tolerance_minutes' => 'required|integer|min:0|max:60',
        'work_days' => 'required|array|min:1',
    ];
    
    public function mount()
    {
        $this->departments = Department::where('is_active', true)->get();
    }
    
    public function updatedSelectedDepartment($value)
    {
        if ($value) {
            $this->schedule = WorkSchedule::where('department_id', $value)->first();
            
            if ($this->schedule) {
                $this->check_in_start = substr($this->schedule->check_in_start, 0, 5);
                $this->check_in_end = substr($this->schedule->check_in_end, 0, 5);
                $this->check_out_start = substr($this->schedule->check_out_start, 0, 5);
                $this->check_out_end = substr($this->schedule->check_out_end, 0, 5);
                $this->late_tolerance_minutes = $this->schedule->late_tolerance_minutes;
                $this->work_days = $this->schedule->work_days;
            } else {
                $this->reset(['check_in_start', 'check_in_end', 'check_out_start', 'check_out_end', 'late_tolerance_minutes', 'work_days']);
                $this->work_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
            }
        }
    }
    
    public function save()
    {
        $this->validate();
        
        WorkSchedule::updateOrCreate(
            ['department_id' => $this->selectedDepartment],
            [
                'check_in_start' => $this->check_in_start . ':00',
                'check_in_end' => $this->check_in_end . ':00',
                'check_out_start' => $this->check_out_start . ':00',
                'check_out_end' => $this->check_out_end . ':00',
                'late_tolerance_minutes' => $this->late_tolerance_minutes,
                'work_days' => $this->work_days,
            ]
        );
        
        session()->flash('message', 'Jadwal kerja berhasil disimpan');
    }
    
    public function render()
    {
        return view('livewire.work-schedule.work-schedule-manage');
    }
}