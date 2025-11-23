<?php

namespace App\Livewire\Leave;

use App\Models\Leave;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveList extends Component
{
    use WithPagination;

    public $status = '';
    public $year = '';
    public $perPage = 10;

    public function mount()
    {
        // Check if user has employee record
        if (!Auth::user()->employee) {
            session()->flash('error', 'Anda tidak memiliki data karyawan. Hubungi HR.');
            $this->year = now()->year;
            return;
        }
        
        $this->year = now()->year;
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingYear()
    {
        $this->resetPage();
    }

    public function cancel($id)
    {
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            session()->flash('error', 'Data karyawan tidak ditemukan.');
            return;
        }
        
        $leave = Leave::findOrFail($id);
        
        // Only allow cancellation if status is pending
        if ($leave->status !== 'pending') {
            session()->flash('error', 'Hanya pengajuan dengan status pending yang dapat dibatalkan.');
            return;
        }
        
        // Check if user is the owner
        if ($leave->employee_id !== $employee->id) {
            session()->flash('error', 'Anda tidak memiliki akses untuk membatalkan pengajuan ini.');
            return;
        }
        
        $leave->update(['status' => 'cancelled']);
        
        session()->flash('message', 'Pengajuan cuti berhasil dibatalkan.');
    }

    public function render()
    {
        $employee = Auth::user()->employee;
        
        // Double check
        if (!$employee) {
            $leaves = new LengthAwarePaginator([], 0, $this->perPage, 1, [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]);

            return view('livewire.leave.leave-list', [
                'leaves' => $leaves,
                'balances' => collect(),
            ]);
        }
        
        $leaves = Leave::with(['leaveType'])
            ->where('employee_id', $employee->id)
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->year, fn($q) => $q->whereYear('start_date', $this->year))
            ->latest()
            ->paginate($this->perPage);
        
        // Get balance summary
        $balances = $employee->leaveBalances()
            ->with('leaveType')
            ->where('year', $this->year)
            ->get();
        
        return view('livewire.leave.leave-list', [
            'leaves' => $leaves,
            'balances' => $balances,
        ]);
    }
}