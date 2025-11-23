{{-- resources/views/livewire/employee/employee-list.blade.php --}}
<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Data Karyawan</h1>
            <p class="text-sm text-secondary-600 mt-1">Kelola data karyawan perusahaan</p>
        </div>
        @can('create employees')
        <a href="{{ route('employees.create') }}" wire:navigate class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Karyawan
        </a>
        @endcan
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-success-50 border border-success-200 text-success-800 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama, NIK, email..." class="form-input">
                </div>
                <div>
                    <select wire:model.live="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                        <option value="resigned">Resign</option>
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
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Departemen</th>
                            <th>Posisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-200">
                        @forelse($employees as $employee)
                        <tr>
                            <td class="font-medium">{{ $employee->employee_number }}</td>
                            <td>{{ $employee->full_name }}</td>
                            <td class="text-secondary-600">{{ $employee->email }}</td>
                            <td>{{ $employee->department->name }}</td>
                            <td>{{ $employee->position->name }}</td>
                            <td>
                                @if($employee->status === 'active')
                                    <span class="badge-success">Aktif</span>
                                @elseif($employee->status === 'inactive')
                                    <span class="badge-warning">Tidak Aktif</span>
                                @else
                                    <span class="badge-danger">Resign</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    @can('edit employees')
                                    <a href="{{ route('employees.edit', $employee) }}" wire:navigate class="text-primary-600 hover:text-primary-900">
                                        Edit
                                    </a>
                                    @endcan
                                    @can('delete employees')
                                    <button wire:click="delete({{ $employee->id }})" 
                                            wire:confirm="Yakin ingin menghapus karyawan ini?"
                                            class="text-danger-600 hover:text-danger-900">
                                        Hapus
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-secondary-500">
                                Tidak ada data karyawan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>