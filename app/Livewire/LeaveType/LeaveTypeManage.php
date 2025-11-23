<?php

namespace App\Livewire\LeaveType;

use App\Models\LeaveType;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveTypeManage extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    // Form fields
    public $leaveTypeId = null;
    public $name = '';
    public $code = '';
    public $max_days = 12;
    public $is_paid = true;
    public $description = '';
    public $is_active = true;
    
    public $isEditing = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:leave_types,code',
        'max_days' => 'required|integer|min:1|max:365',
        'is_paid' => 'boolean',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'Nama tipe cuti wajib diisi.',
        'code.required' => 'Kode tipe cuti wajib diisi.',
        'code.unique' => 'Kode tipe cuti sudah digunakan.',
        'max_days.required' => 'Maksimal hari wajib diisi.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['leaveTypeId', 'name', 'code', 'max_days', 'description', 'is_paid', 'is_active']);
        $this->max_days = 12;
        $this->is_paid = true;
        $this->is_active = true;
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        
        $this->leaveTypeId = $leaveType->id;
        $this->name = $leaveType->name;
        $this->code = $leaveType->code;
        $this->max_days = $leaveType->max_days;
        $this->is_paid = $leaveType->is_paid;
        $this->description = $leaveType->description;
        $this->is_active = $leaveType->is_active;
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->isEditing) {
            $this->rules['code'] = 'required|string|max:50|unique:leave_types,code,' . $this->leaveTypeId;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'max_days' => $this->max_days,
            'is_paid' => $this->is_paid,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            LeaveType::find($this->leaveTypeId)->update($data);
            session()->flash('message', 'Tipe cuti berhasil diupdate.');
        } else {
            LeaveType::create($data);
            session()->flash('message', 'Tipe cuti berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        
        if ($leaveType->leaves()->count() > 0) {
            session()->flash('error', 'Tidak dapat menghapus tipe cuti yang sudah digunakan.');
            return;
        }
        
        $leaveType->delete();
        session()->flash('message', 'Tipe cuti berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['leaveTypeId', 'name', 'code', 'max_days', 'description', 'is_paid', 'is_active']);
        $this->resetValidation();
    }

    public function render()
    {
        $leaveTypes = LeaveType::query()
            ->withCount('leaves')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.leave-type.leave-type-manage', [
            'leaveTypes' => $leaveTypes,
        ]);
    }
}