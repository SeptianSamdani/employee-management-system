<?php
// app/Livewire/Employee/EmployeeList.php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $perPage = 10;

    protected $queryString = ['search', 'status'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        
        session()->flash('message', 'Karyawan berhasil dihapus.');
    }

    public function render()
    {
        $employees = Employee::query()
            ->with(['department:id,name', 'position:id,name']) // Eager loading
            ->select('id', 'employee_number', 'full_name', 'email', 'department_id', 'position_id', 'status')
            ->when($this->search, fn($q) => $q->where(...))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.employee.employee-list', [
            'employees' => $employees
        ]);
    }
}