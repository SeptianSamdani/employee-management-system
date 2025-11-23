<div>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-secondary-900">Riwayat Absensi Saya</h1>
        <p class="text-sm text-secondary-600 mt-1">Lihat history kehadiran Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-secondary-600">Total Hari</p>
                <p class="text-2xl font-bold text-secondary-900">{{ $stats['total_days'] }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-secondary-600">Hadir</p>
                <p class="text-2xl font-bold text-success-600">{{ $stats['present'] }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-secondary-600">Terlambat</p>
                <p class="text-2xl font-bold text-warning-600">{{ $stats['late'] }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-secondary-600">Tidak Hadir</p>
                <p class="text-2xl font-bold text-danger-600">{{ $stats['absent'] }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Bulan</label>
                    <select wire:model.live="month" class="form-input">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="form-label">Tahun</label>
                    <select wire:model.live="year" class="form-input">
                        @for($y = now()->year; $y >= now()->year - 2; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $att)
                        <tr>
                            <td>{{ $att->date->isoFormat('dddd, D MMM Y') }}</td>
                            <td>
                                <span class="font-medium">{{ $att->check_in ? substr($att->check_in, 0, 5) : '-' }}</span>
                                @if($att->scheduled_in)
                                    <span class="text-xs text-secondary-500">({{ substr($att->scheduled_in, 0, 5) }})</span>
                                @endif
                            </td>
                            <td>
                                <span class="font-medium">{{ $att->check_out ? substr($att->check_out, 0, 5) : '-' }}</span>
                                @if($att->scheduled_out)
                                    <span class="text-xs text-secondary-500">({{ substr($att->scheduled_out, 0, 5) }})</span>
                                @endif
                            </td>
                            <td>
                                @if($att->status === 'present')
                                    <span class="badge-success">Hadir</span>
                                @elseif($att->status === 'late')
                                    <span class="badge-warning">Terlambat</span>
                                @else
                                    <span class="badge-danger">Tidak Hadir</span>
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($att->is_late)
                                    <span class="text-warning-600">Terlambat {{ $att->late_minutes }} menit</span>
                                @else
                                    <span class="text-success-600">Tepat waktu</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-secondary-500">
                                Tidak ada data absensi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>