<?php
// app/Livewire/Employee/EmployeeCreate.php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmployeeCreate extends Component
{
    use WithFileUploads;

    public $full_name = '';
    public $email = '';
    public $phone = '';
    public $date_of_birth = '';
    public $gender = '';
    public $address = '';
    public $identity_number = '';
    public $department_id = '';
    public $position_id = '';
    public $join_date = '';
    public $employment_status = 'contract';
    public $photo;
    
    public $departments = [];
    public $positions = [];

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|unique:employees,email',
        'phone' => 'nullable|string|max:20',
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|in:male,female',
        'address' => 'nullable|string',
        'identity_number' => 'nullable|string|max:50',
        'department_id' => 'required|exists:departments,id',
        'position_id' => 'required|exists:positions,id',
        'join_date' => 'required|date',
        'employment_status' => 'required|in:contract,permanent,internship',
        'photo' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'email.unique' => 'Email sudah digunakan.',
        'full_name.required' => 'Nama lengkap wajib diisi.',
        'department_id.required' => 'Departemen wajib dipilih.',
        'position_id.required' => 'Posisi wajib dipilih.',
        'join_date.required' => 'Tanggal bergabung wajib diisi.',
    ];

    public function mount()
    {
        $this->departments = Department::where('is_active', true)->get();
        $this->join_date = now()->format('Y-m-d');
    }

    public function updatedDepartmentId($value)
    {
        $this->positions = Position::where('department_id', $value)
            ->where('is_active', true)
            ->get();
        $this->position_id = '';
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        
        try {
            // Create User
            $user = User::create([
                'name' => $this->full_name,
                'email' => $this->email,
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
            
            $user->assignRole('employee');

            // Generate Employee Number
            $lastEmployee = Employee::latest('id')->first();
            $number = $lastEmployee ? intval(substr($lastEmployee->employee_number, 3)) + 1 : 1;
            $employeeNumber = 'EMP' . str_pad($number, 5, '0', STR_PAD_LEFT);

            // Handle Photo
            $photoPath = null;
            if ($this->photo) {
                $photoPath = $this->photo->store('employees', 'public');
            }

            // Create Employee
            Employee::create([
                'user_id' => $user->id,
                'employee_number' => $employeeNumber,
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
                'employment_status' => $this->employment_status,
                'status' => 'active',
                'photo' => $photoPath,
            ]);

            DB::commit();

            session()->flash('message', 'Karyawan berhasil ditambahkan.');
            
            return redirect()->route('employees.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded photo if exists
            if ($this->photo && isset($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            
            // Log error untuk debugging
            Log::error('Employee Create Error: ' . $e->getMessage());
            
            // Tampilkan error spesifik
            if (str_contains($e->getMessage(), 'Unique constraint')) {
                $this->addError('email', 'Email sudah digunakan di sistem.');
            } else {
                $this->addError('email', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-create');
    }
}