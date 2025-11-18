<div>
    <div class="mb-6 flex justify-between">
        <h1 class="text-2xl font-semibold">Laporan Kehadiran</h1>
        <button wire:click="export" class="btn-primary">Export Excel</button>
    </div>
    
    <div class="card mb-6">
        <div class="card-body">
            <div class="grid grid-cols-4 gap-4">
                <input wire:model.live="search" type="text" placeholder="Cari nama..." class="form-input">
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
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                    <th>Terlambat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $att)
                <tr>
                    <td>{{ $att->date->format('d/m/Y') }}</td>
                    <td>{{ $att->employee->full_name }}</td>
                    <td>{{ $att->check_in }}</td>
                    <td>{{ $att->check_out ?? '-' }}</td>
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
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">{{ $attendances->links() }}</div>
</div>