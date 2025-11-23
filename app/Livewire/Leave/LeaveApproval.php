<?php

namespace App\Livewire\Leave;

use App\Models\Leave;
use App\Models\EmployeeLeaveBalance;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveApproval extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'pending';
    public $department_id = '';
    public $perPage = 10;
    
    // Modal properties
    public $showModal = false;
    public $selectedLeave = null;
    public $modalAction = '';
    public $rejection_reason = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openApprovalModal($leaveId, $action)
    {
        $this->selectedLeave = Leave::with(['employee.department', 'leaveType'])->findOrFail($leaveId);
        $this->modalAction = $action;
        $this->rejection_reason = '';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedLeave = null;
        $this->modalAction = '';
        $this->rejection_reason = '';
        $this->resetValidation();
    }

    public function approve()
    {
        if (!$this->selectedLeave) return;

        DB::beginTransaction();
        
        try {
            $leave = $this->selectedLeave;
            
            // Update leave status
            $leave->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
            
            // Update employee leave balance
            $currentYear = $leave->start_date->year;
            $balance = EmployeeLeaveBalance::where('employee_id', $leave->employee_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->where('year', $currentYear)
                ->first();
            
            if ($balance) {
                $balance->update([
                    'used_days' => $balance->used_days + $leave->total_days,
                    'remaining_days' => $balance->remaining_days - $leave->total_days,
                ]);
            }
            
            DB::commit();
            
            session()->flash('message', 'Pengajuan cuti berhasil disetujui.');
            $this->closeModal();
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject()
    {
        if (!$this->selectedLeave) return;

        $this->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        try {
            $this->selectedLeave->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'rejection_reason' => $this->rejection_reason,
            ]);
            
            session()->flash('message', 'Pengajuan cuti berhasil ditolak.');
            $this->closeModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $user = Auth::user();
        
        // Build query based on role
        $query = Leave::with(['employee.department', 'employee.position', 'leaveType', 'approver'])
            ->when($this->search, fn($q) => 
                $q->whereHas('employee', fn($q2) => 
                    $q2->where('full_name', 'like', "%{$this->search}%")
                        ->orWhere('employee_number', 'like', "%{$this->search}%")
                )
            )
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->department_id, fn($q) =>
                $q->whereHas('employee', fn($q2) =>
                    $q2->where('department_id', $this->department_id)
                )
            );
        
        // If manager (not admin/hr), only show leaves from their department
        if ($user->hasRole('manager') && !$user->hasAnyRole(['admin', 'hr'])) {
            $managerEmployee = $user->employee;
            if ($managerEmployee) {
                $query->whereHas('employee', fn($q) => 
                    $q->where('department_id', $managerEmployee->department_id)
                );
            }
        }
        
        $leaves = $query->latest()->paginate($this->perPage);
        
        $departments = Department::where('is_active', true)->get();
        
        // Statistics
        $stats = [
            'pending' => Leave::where('status', 'pending')->count(),
            'approved' => Leave::where('status', 'approved')
                ->whereMonth('start_date', now()->month)
                ->count(),
            'rejected' => Leave::where('status', 'rejected')
                ->whereMonth('start_date', now()->month)
                ->count(),
        ];
        
        return view('livewire.leave.leave-approval', [
            'leaves' => $leaves,
            'departments' => $departments,
            'stats' => $stats,
        ]);
    }
}