<?php
// app/Livewire/Employee/EmployeeEdit.php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EmployeeEdit extends Component
{
    use WithFileUploads;

    public Employee $employee;
    
    public $full_name;
    public $email;
    public $phone;
    public $date_of_birth;
    public $gender;
    public $address;
    public $identity_number;
    public $department_id;
    public $position_id;
    public $join_date;
    public $resign_date;
    public $employment_status;
    public $status;
    public $photo;
    public $existing_photo;
    
    public $departments = [];
    public $positions = [];

    protected function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->employee->user_id . '|unique:employees,email,' . $this->employee->id, // Update ini
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'identity_number' => 'nullable|string|max:50',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'join_date' => 'required|date',
            'resign_date' => 'nullable|date',
            'employment_status' => 'required|in:contract,permanent,internship',
            'status' => 'required|in:active,inactive,resigned',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    protected $messages = [
        'email.unique' => 'Email sudah digunakan.',
        'full_name.required' => 'Nama lengkap wajib diisi.',
        'department_id.required' => 'Departemen wajib dipilih.',
        'position_id.required' => 'Posisi wajib dipilih.',
        'join_date.required' => 'Tanggal bergabung wajib diisi.',
    ];

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
        
        $this->full_name = $employee->full_name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->date_of_birth = $employee->date_of_birth?->format('Y-m-d');
        $this->gender = $employee->gender;
        $this->address = $employee->address;
        $this->identity_number = $employee->identity_number;
        $this->department_id = $employee->department_id;
        $this->position_id = $employee->position_id;
        $this->join_date = $employee->join_date->format('Y-m-d');
        $this->resign_date = $employee->resign_date?->format('Y-m-d');
        $this->employment_status = $employee->employment_status;
        $this->status = $employee->status;
        $this->existing_photo = $employee->photo;
        
        $this->departments = Department::where('is_active', true)->get();
        $this->positions = Position::where('department_id', $this->department_id)
            ->where('is_active', true)
            ->get();
    }

    public function updatedDepartmentId($value)
    {
        $this->positions = Position::where('department_id', $value)
            ->where('is_active', true)
            ->get();
        $this->position_id = '';
    }

    public function update()
    {
        $this->validate();

        DB::beginTransaction();
        
        try {
            // Handle Photo
            if ($this->photo) {
                if ($this->existing_photo) {
                    Storage::disk('public')->delete($this->existing_photo);
                }
                $photoPath = $this->photo->store('employees', 'public');
            } else {
                $photoPath = $this->existing_photo;
            }

            // Update Employee
            $this->employee->update([
                'full_name' => $this->full_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'address' => $this->address,
                'identity_number' => $this->identity_number,
                'department_id' => $this->department_id,
                'position_id' => $this->position_id,
                'join_date' => $this->join_date,
                'resign_date' => $this->resign_date,
                'employment_status' => $this->employment_status,
                'status' => $this->status,
                'photo' => $photoPath,
            ]);

            // Update User Email
            $this->employee->user->update([
                'name' => $this->full_name,
                'email' => $this->email,
            ]);

            DB::commit();

            session()->flash('message', 'Karyawan berhasil diupdate.');
            
            return redirect()->route('employees.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->addError('email', 'Terjadi kesalahan saat update data.');
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-edit');
    }
}