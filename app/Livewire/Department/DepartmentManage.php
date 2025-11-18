<?php

namespace App\Livewire\Department;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentManage extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    // Form fields
    public $departmentId = null;
    public $name = '';
    public $code = '';
    public $description = '';
    public $manager_id = '';
    public $is_active = true;
    
    public $isEditing = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:departments,code',
        'description' => 'nullable|string',
        'manager_id' => 'nullable|exists:users,id',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'Nama departemen wajib diisi.',
        'code.required' => 'Kode departemen wajib diisi.',
        'code.unique' => 'Kode departemen sudah digunakan.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['departmentId', 'name', 'code', 'description', 'manager_id', 'is_active']);
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        
        $this->departmentId = $department->id;
        $this->name = $department->name;
        $this->code = $department->code;
        $this->description = $department->description;
        $this->manager_id = $department->manager_id;
        $this->is_active = $department->is_active;
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->isEditing) {
            $this->rules['code'] = 'required|string|max:50|unique:departments,code,' . $this->departmentId;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'manager_id' => $this->manager_id ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            Department::find($this->departmentId)->update($data);
            session()->flash('message', 'Departemen berhasil diupdate.');
        } else {
            Department::create($data);
            session()->flash('message', 'Departemen berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $department = Department::findOrFail($id);
        
        if ($department->employees()->count() > 0) {
            session()->flash('error', 'Tidak dapat menghapus departemen yang masih memiliki karyawan.');
            return;
        }
        
        $department->delete();
        session()->flash('message', 'Departemen berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['departmentId', 'name', 'code', 'description', 'manager_id', 'is_active']);
        $this->resetValidation();
    }

    public function render()
    {
        $departments = Department::query()
            ->with(['manager', 'employees'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        $managers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin', 'hr', 'manager']);
        })->get();

        return view('livewire.department.department-manage', [
            'departments' => $departments,
            'managers' => $managers,
        ]);
    }
}