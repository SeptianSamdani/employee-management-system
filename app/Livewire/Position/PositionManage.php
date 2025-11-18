<?php

namespace App\Livewire\Position;

use App\Models\Position;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class PositionManage extends Component
{
    use WithPagination;

    public $search = '';
    public $filterDepartment = '';
    public $perPage = 10;
    
    // Form fields
    public $positionId = null;
    public $name = '';
    public $code = '';
    public $department_id = '';
    public $base_salary = 0;
    public $description = '';
    public $is_active = true;
    
    public $isEditing = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:positions,code',
        'department_id' => 'required|exists:departments,id',
        'base_salary' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'Nama posisi wajib diisi.',
        'code.required' => 'Kode posisi wajib diisi.',
        'code.unique' => 'Kode posisi sudah digunakan.',
        'department_id.required' => 'Departemen wajib dipilih.',
        'base_salary.required' => 'Gaji pokok wajib diisi.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterDepartment()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['positionId', 'name', 'code', 'department_id', 'base_salary', 'description', 'is_active']);
        $this->base_salary = 0;
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        
        $this->positionId = $position->id;
        $this->name = $position->name;
        $this->code = $position->code;
        $this->department_id = $position->department_id;
        $this->base_salary = $position->base_salary;
        $this->description = $position->description;
        $this->is_active = $position->is_active;
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->isEditing) {
            $this->rules['code'] = 'required|string|max:50|unique:positions,code,' . $this->positionId;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'department_id' => $this->department_id,
            'base_salary' => $this->base_salary,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            Position::find($this->positionId)->update($data);
            session()->flash('message', 'Posisi berhasil diupdate.');
        } else {
            Position::create($data);
            session()->flash('message', 'Posisi berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $position = Position::findOrFail($id);
        
        if ($position->employees()->count() > 0) {
            session()->flash('error', 'Tidak dapat menghapus posisi yang masih memiliki karyawan.');
            return;
        }
        
        $position->delete();
        session()->flash('message', 'Posisi berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['positionId', 'name', 'code', 'department_id', 'base_salary', 'description', 'is_active']);
        $this->resetValidation();
    }

    public function render()
    {
        $positions = Position::query()
            ->with(['department', 'employees'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterDepartment, function ($query) {
                $query->where('department_id', $this->filterDepartment);
            })
            ->latest()
            ->paginate($this->perPage);

        $departments = Department::where('is_active', true)->get();

        return view('livewire.position.position-manage', [
            'positions' => $positions,
            'departments' => $departments,
        ]);
    }
}