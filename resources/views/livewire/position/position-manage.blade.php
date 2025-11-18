<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-secondary-900">Manajemen Posisi</h1>
            <p class="text-sm text-secondary-600 mt-1">Kelola posisi jabatan perusahaan</p>
        </div>
        @can('manage departments')
        <button wire:click="create" class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Posisi
        </button>
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

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau kode..." class="form-input">
                </div>
                <div>
                    <select wire:model.live="filterDepartment" class="form-input">
                        <option value="">Semua Departemen</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
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
                            <th>Kode</th>
                            <th>Nama Posisi</th>
                            <th>Departemen</th>
                            <th>Gaji Pokok</th>
                            <th>Jumlah Karyawan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-200">
                        @forelse($positions as $position)
                        <tr>
                            <td class="font-medium">{{ $position->code }}</td>
                            <td>
                                <div class="font-medium text-secondary-900">{{ $position->name }}</div>
                                @if($position->description)
                                <div class="text-xs text-secondary-500">{{ Str::limit($position->description, 50) }}</div>
                                @endif
                            </td>
                            <td>{{ $position->department->name }}</td>
                            <td class="font-medium">Rp {{ number_format($position->base_salary, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-primary">{{ $position->employees->count() }} orang</span>
                            </td>
                            <td>
                                @if($position->is_active)
                                    <span class="badge-success">Aktif</span>
                                @else
                                    <span class="badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @can('manage departments')
                                <div class="flex items-center space-x-2">
                                    <button wire:click="edit({{ $position->id }})" class="text-primary-600 hover:text-primary-900">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $position->id }})" 
                                            wire:confirm="Yakin ingin menghapus posisi ini?"
                                            class="text-danger-600 hover:text-danger-900">
                                        Hapus
                                    </button>
                                </div>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-secondary-500">
                                Tidak ada data posisi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $positions->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data x-show="true" x-transition>
        <div class="flex min-h-screen items-center justify-center px-4">
            <div class="fixed inset-0 bg-secondary-900 bg-opacity-50 transition-opacity" wire:click="closeModal"></div>
            
            <div class="relative bg-white rounded-lg max-w-lg w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-secondary-900">
                        {{ $isEditing ? 'Edit Posisi' : 'Tambah Posisi' }}
                    </h3>
                    <button wire:click="closeModal" class="text-secondary-400 hover:text-secondary-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="form-label">Nama Posisi <span class="text-danger-500">*</span></label>
                        <input wire:model="name" type="text" class="form-input" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label">Kode <span class="text-danger-500">*</span></label>
                        <input wire:model="code" type="text" class="form-input" required>
                        @error('code') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label">Departemen <span class="text-danger-500">*</span></label>
                        <select wire:model="department_id" class="form-input" required>
                            <option value="">Pilih Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label">Gaji Pokok <span class="text-danger-500">*</span></label>
                        <input wire:model="base_salary" type="number" min="0" step="1000" class="form-input" required>
                        @error('base_salary') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label">Deskripsi</label>
                        <textarea wire:model="description" rows="3" class="form-input"></textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input wire:model="is_active" type="checkbox" id="is_active_pos" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded">
                        <label for="is_active_pos" class="ml-2 block text-sm text-secondary-900">
                            Aktif
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="closeModal" class="btn-outline">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary">
                            {{ $isEditing ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>