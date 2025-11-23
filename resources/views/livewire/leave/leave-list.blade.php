<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Riwayat Cuti Saya</h1>
            <p class="text-sm text-secondary-600 mt-1">Kelola dan pantau pengajuan cuti Anda</p>
        </div>
        @can('create leaves')
        <a href="{{ route('leaves.request') }}" wire:navigate class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajukan Cuti
        </a>
        @endcan
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

    <!-- Balance Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach($balances as $balance)
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-secondary-600 mb-1">{{ $balance->leaveType->name }}</p>
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-primary-600">{{ $balance->remaining_days }}</span>
                    <span class="text-sm text-secondary-500 ml-1">/ {{ $balance->total_days }} hari</span>
                </div>
                <div class="mt-2 w-full bg-secondary-200 rounded-full h-2">
                    <div class="bg-primary-600 h-2 rounded-full" style="width: {{ ($balance->remaining_days / $balance->total_days) * 100 }}%"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <select wire:model.live="year" class="form-input">
                        @for($y = now()->year; $y >= now()->year - 2; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
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
                            <th>Tipe Cuti</th>
                            <th>Tanggal</th>
                            <th>Durasi</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        <tr>
                            <td class="font-medium">{{ $leave->leaveType->name }}</td>
                            <td>
                                <div class="text-sm">
                                    <div>{{ $leave->start_date->format('d M Y') }}</div>
                                    <div class="text-secondary-500">s/d {{ $leave->end_date->format('d M Y') }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="font-semibold">{{ $leave->total_days }}</span> hari
                            </td>
                            <td class="max-w-xs truncate">{{ $leave->reason }}</td>
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
                                    <button wire:click="cancel({{ $leave->id }})" 
                                            wire:confirm="Yakin ingin membatalkan pengajuan cuti ini?"
                                            class="text-danger-600 hover:text-danger-900 text-sm">
                                        Batalkan
                                    </button>
                                @else
                                    <span class="text-secondary-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-secondary-500">
                                Tidak ada riwayat cuti
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
</div>