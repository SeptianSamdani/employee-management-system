<div>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-secondary-900">Approval Cuti</h1>
        <p class="text-sm text-secondary-600 mt-1">Review dan setujui pengajuan cuti karyawan</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-success-50 border border-success-200 text-success-800 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-danger-50 border border-danger-200 text-danger-800 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-secondary-600">Pending</p>
                        <p class="text-2xl font-bold text-warning-600">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="p-3 bg-warning-100 rounded-lg">
                        <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-secondary-600">Disetujui (Bulan Ini)</p>
                        <p class="text-2xl font-bold text-success-600">{{ $stats['approved'] }}</p>
                    </div>
                    <div class="p-3 bg-success-100 rounded-lg">
                        <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-secondary-600">Ditolak (Bulan Ini)</p>
                        <p class="text-2xl font-bold text-danger-600">{{ $stats['rejected'] }}</p>
                    </div>
                    <div class="p-3 bg-danger-100 rounded-lg">
                        <svg class="w-6 h-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama/NIK..." class="form-input">
                </div>
                <div>
                    <select wire:model.live="department_id" class="form-input">
                        <option value="">Semua Departemen</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select wire:model.live="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <select wire:model.live="perPage" class="form-input">
                        <option value="10">10 per halaman</option>
                        <option value="25">25 per halaman</option>
                        <option value="50">50 per halaman</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Departemen</th>
                            <th>Tipe Cuti</th>
                            <th>Tanggal</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        <tr>
                            <td>
                                <div>
                                    <div class="font-medium">{{ $leave->employee->full_name }}</div>
                                    <div class="text-xs text-secondary-500">{{ $leave->employee->employee_number }}</div>
                                </div>
                            </td>
                            <td>{{ $leave->employee->department->name }}</td>
                            <td>
                                <span class="font-medium">{{ $leave->leaveType->name }}</span>
                                @if(!$leave->leaveType->is_paid)
                                    <span class="badge-warning text-xs ml-1">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div>{{ $leave->start_date->format('d M Y') }}</div>
                                    <div class="text-secondary-500">s/d {{ $leave->end_date->format('d M Y') }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="font-semibold">{{ $leave->total_days }}</span> hari
                            </td>
                            <td>
                                @if($leave->status === 'pending')
                                    <span class="badge-warning">Pending</span>
                                @elseif($leave->status === 'approved')
                                    <span class="badge-success">Disetujui</span>
                                @elseif($leave->status === 'rejected')
                                    <span class="badge-danger">Ditolak</span>
                                @else
                                    <span class="badge-secondary">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                @if($leave->status === 'pending')
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="openApprovalModal({{ $leave->id }}, 'approve')" 
                                                class="text-success-600 hover:text-success-900 text-sm font-medium">
                                            Setujui
                                        </button>
                                        <button wire:click="openApprovalModal({{ $leave->id }}, 'reject')" 
                                                class="text-danger-600 hover:text-danger-900 text-sm font-medium">
                                            Tolak
                                        </button>
                                    </div>
                                @else
                                    <div class="text-xs text-secondary-500">
                                        @if($leave->approver)
                                            Oleh: {{ $leave->approver->name }}<br>
                                            {{ $leave->approved_at->format('d M Y H:i') }}
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-secondary-500">
                                Tidak ada pengajuan cuti
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $leaves->links() }}
            </div>
        </div>
    </div>

    <!-- Approval Modal -->
    @if($showModal && $selectedLeave)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center px-4">
            <div class="fixed inset-0 bg-secondary-900 bg-opacity-50 transition-opacity" wire:click="closeModal"></div>
            
            <div class="relative bg-white rounded-lg max-w-2xl w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-secondary-900">
                        {{ $modalAction === 'approve' ? 'Setujui' : 'Tolak' }} Pengajuan Cuti
                    </h3>
                    <button wire:click="closeModal" class="text-secondary-400 hover:text-secondary-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Leave Details -->
                <div class="bg-secondary-50 rounded-lg p-4 mb-4 space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-secondary-600">Karyawan</p>
                            <p class="font-medium">{{ $selectedLeave->employee->full_name }}</p>
                            <p class="text-xs text-secondary-500">{{ $selectedLeave->employee->employee_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-secondary-600">Departemen</p>
                            <p class="font-medium">{{ $selectedLeave->employee->department->name }}</p>
                            <p class="text-xs text-secondary-500">{{ $selectedLeave->employee->position->name }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t pt-3 grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-secondary-600">Tipe Cuti</p>
                            <p class="font-medium">{{ $selectedLeave->leaveType->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-secondary-600">Durasi</p>
                            <p class="font-medium">{{ $selectedLeave->total_days }} hari</p>
                        </div>
                        <div>
                            <p class="text-xs text-secondary-600">Status Gaji</p>
                            @if($selectedLeave->leaveType->is_paid)
                                <span class="badge-success">Dibayar</span>
                            @else
                                <span class="badge-warning">Tidak Dibayar</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="border-t pt-3">
                        <p class="text-xs text-secondary-600 mb-1">Periode Cuti</p>
                        <p class="font-medium">
                            {{ $selectedLeave->start_date->format('d F Y') }} - {{ $selectedLeave->end_date->format('d F Y') }}
                        </p>
                    </div>
                    
                    <div class="border-t pt-3">
                        <p class="text-xs text-secondary-600 mb-1">Alasan</p>
                        <p class="text-sm">{{ $selectedLeave->reason }}</p>
                    </div>
                    
                    @if($selectedLeave->attachment)
                    <div class="border-t pt-3">
                        <p class="text-xs text-secondary-600 mb-1">Lampiran</p>
                        <a href="{{ Storage::url($selectedLeave->attachment) }}" 
                           target="_blank"
                           class="text-sm text-primary-600 hover:text-primary-800 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            Lihat Lampiran
                        </a>
                    </div>
                    @endif
                </div>

                @if($modalAction === 'reject')
                <!-- Rejection Reason Form -->
                <div class="mb-4">
                    <label class="form-label">Alasan Penolakan <span class="text-danger-500">*</span></label>
                    <textarea wire:model="rejection_reason" rows="4" class="form-input" placeholder="Jelaskan alasan penolakan..." required></textarea>
                    @error('rejection_reason') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                @endif

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <button wire:click="closeModal" class="btn-outline">
                        Batal
                    </button>
                    @if($modalAction === 'approve')
                        <button wire:click="approve" 
                                wire:confirm="Yakin ingin menyetujui pengajuan cuti ini?"
                                class="btn-primary bg-success-600 hover:bg-success-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Setujui Cuti
                        </button>
                    @else
                        <button wire:click="reject" class="btn-danger">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak Cuti
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>