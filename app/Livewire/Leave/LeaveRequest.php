<?php

namespace App\Livewire\Leave;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\EmployeeLeaveBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class LeaveRequest extends Component
{
    use WithFileUploads;

    public $leave_type_id = '';
    public $start_date = '';
    public $end_date = '';
    public $reason = '';
    public $attachment;
    
    public $leaveTypes = [];
    public $selectedLeaveType = null;
    public $totalDays = 0;
    public $remainingBalance = 0;

    protected $rules = [
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|min:10',
        'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];

    protected $messages = [
        'leave_type_id.required' => 'Tipe cuti wajib dipilih.',
        'start_date.required' => 'Tanggal mulai wajib diisi.',
        'start_date.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
        'end_date.required' => 'Tanggal selesai wajib diisi.',
        'end_date.after_or_equal' => 'Tanggal selesai tidak boleh kurang dari tanggal mulai.',
        'reason.required' => 'Alasan cuti wajib diisi.',
        'reason.min' => 'Alasan minimal 10 karakter.',
    ];

    public function mount()
    {
        // Check if user has employee record
        if (!Auth::user()->employee) {
            session()->flash('error', 'Anda tidak memiliki data karyawan. Hubungi HR.');
            return redirect()->route('dashboard');
        }
        
        $this->leaveTypes = LeaveType::where('is_active', true)->get();
        $this->start_date = now()->addDay()->format('Y-m-d');
        $this->end_date = now()->addDay()->format('Y-m-d');
    }

    public function updatedLeaveTypeId($value)
    {
        if ($value) {
            $this->selectedLeaveType = LeaveType::find($value);
            $this->checkBalance();
        }
    }

    public function updatedStartDate()
    {
        $this->calculateTotalDays();
    }

    public function updatedEndDate()
    {
        $this->calculateTotalDays();
    }

    public function calculateTotalDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            
            // Calculate business days (excluding weekends)
            $totalDays = 0;
            $current = $start->copy();
            
            while ($current->lte($end)) {
                if (!$current->isWeekend()) {
                    $totalDays++;
                }
                $current->addDay();
            }
            
            $this->totalDays = $totalDays;
        }
    }

    public function checkBalance()
    {
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            $this->remainingBalance = 0;
            return;
        }
        
        $currentYear = now()->year;
        
        $balance = EmployeeLeaveBalance::where('employee_id', $employee->id)
            ->where('leave_type_id', $this->leave_type_id)
            ->where('year', $currentYear)
            ->first();
        
        if (!$balance && $this->selectedLeaveType) {
            // Create initial balance if not exists
            $balance = EmployeeLeaveBalance::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $this->leave_type_id,
                'year' => $currentYear,
                'total_days' => $this->selectedLeaveType->max_days,
                'used_days' => 0,
                'remaining_days' => $this->selectedLeaveType->max_days,
            ]);
        }
        
        $this->remainingBalance = $balance ? $balance->remaining_days : 0;
    }

    public function submit()
    {
        $this->validate();
        
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            session()->flash('error', 'Data karyawan tidak ditemukan.');
            return;
        }
        
        // Check if balance is sufficient
        if ($this->totalDays > $this->remainingBalance) {
            $this->addError('leave_type_id', 'Sisa kuota cuti tidak mencukupi. Sisa: ' . $this->remainingBalance . ' hari');
            return;
        }
        
        // Check for overlapping leaves
        $overlapping = Leave::where('employee_id', $employee->id)
            ->where('status', '!=', 'rejected')
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<=', $this->start_date)
                          ->where('end_date', '>=', $this->end_date);
                    });
            })
            ->exists();
        
        if ($overlapping) {
            $this->addError('start_date', 'Anda sudah memiliki pengajuan cuti pada tanggal tersebut.');
            return;
        }
        
        DB::beginTransaction();
        
        try {
            // Handle attachment
            $attachmentPath = null;
            if ($this->attachment) {
                $attachmentPath = $this->attachment->store('leave-attachments', 'public');
            }
            
            // Create leave request
            Leave::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $this->leave_type_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'total_days' => $this->totalDays,
                'reason' => $this->reason,
                'status' => 'pending',
                'attachment' => $attachmentPath,
            ]);
            
            DB::commit();
            
            session()->flash('message', 'Pengajuan cuti berhasil dikirim dan menunggu persetujuan.');
            
            return redirect()->route('leaves.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }
            
            $this->addError('leave_type_id', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function render()
    {
        return view('livewire.leave.leave-request');
    }
}