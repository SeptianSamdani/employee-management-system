<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold">Laporan Kehadiran</h1>
            <p class="text-sm text-secondary-600 mt-1">Data absensi seluruh karyawan</p>
        </div>
        <button wire:click="export" class="btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export Excel
        </button>
    </div>
    
    <div class="card mb-6">
        <div class="card-body">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama/NIK..." class="form-input">
                <select wire:model.live="department_id" class="form-input">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
                <input wire:model.live="dateFrom" type="date" class="form-input">
                <input wire:model.live="dateTo" type="date" class="form-input">
                <select wire:model.live="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="present">Hadir</option>
                    <option value="late">Terlambat</option>
                    <option value="absent">Tidak Hadir</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Terlambat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $att)
                        <tr>
                            <td>{{ $att->date->format('d/m/Y') }}</td>
                            <td class="font-medium">{{ $att->employee->employee_number }}</td>
                            <td>{{ $att->employee->full_name }}</td>
                            <td>{{ $att->employee->department->name }}</td>
                            <td>{{ $att->check_in ? substr($att->check_in, 0, 5) : '-' }}</td>
                            <td>{{ $att->check_out ? substr($att->check_out, 0, 5) : '-' }}</td>
                            <td>
                                @if($att->status === 'present')
                                    <span class="badge-success">Hadir</span>
                                @elseif($att->status === 'late')
                                    <span class="badge-warning">Terlambat</span>
                                @else
                                    <span class="badge-danger">Tidak Hadir</span>
                                @endif
                            </td>
                            <td>{{ $att->late_minutes ? $att->late_minutes . ' menit' : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-secondary-500">
                                Tidak ada data absensi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>