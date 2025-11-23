{{-- resources/views/livewire/employee/employee-create.blade.php --}}
<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Tambah Karyawan</h1>
                <p class="text-sm text-secondary-600 mt-1">Isi form untuk menambah karyawan baru</p>
            </div>
            <a href="{{ route('employees.index') }}" wire:navigate class="btn-outline">
                Kembali
            </a>
        </div>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Pribadi -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-secondary-900">Data Pribadi</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div>
                            <label class="form-label">Nama Lengkap <span class="text-danger-500">*</span></label>
                            <input wire:model="full_name" type="text" class="form-input" required>
                            @error('full_name') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="form-label">Email <span class="text-danger-500">*</span></label>
                                <input wire:model="email" type="email" class="form-input" required>
                                @error('email') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="form-label">No. Telepon</label>
                                <input wire:model="phone" type="text" class="form-input">
                                @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="form-label">Tanggal Lahir</label>
                                <input wire:model="date_of_birth" type="date" class="form-input">
                                @error('date_of_birth') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="form-label">Jenis Kelamin</label>
                                <select wire:model="gender" class="form-input">
                                    <option value="">Pilih</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                                @error('gender') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="form-label">No. KTP</label>
                            <input wire:model="identity_number" type="text" class="form-input">
                            @error('identity_number') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="form-label">Alamat</label>
                            <textarea wire:model="address" rows="3" class="form-input"></textarea>
                            @error('address') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Kepegawaian -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-secondary-900">Data Kepegawaian</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="form-label">Departemen <span class="text-danger-500">*</span></label>
                                <select wire:model.live="department_id" class="form-input" required>
                                    <option value="">Pilih Departemen</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="form-label">Posisi <span class="text-danger-500">*</span></label>
                                <select wire:model="position_id" class="form-input" required>
                                    <option value="">Pilih Posisi</option>
                                    @foreach($positions as $pos)
                                        <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                                    @endforeach
                                </select>
                                @error('position_id') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="form-label">Tanggal Bergabung <span class="text-danger-500">*</span></label>
                                <input wire:model="join_date" type="date" class="form-input" required>
                                @error('join_date') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="form-label">Status Kepegawaian <span class="text-danger-500">*</span></label>
                                <select wire:model="employment_status" class="form-input" required>
                                    <option value="contract">Kontrak</option>
                                    <option value="permanent">Tetap</option>
                                    <option value="internship">Magang</option>
                                </select>
                                @error('employment_status') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Photo Upload -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-secondary-900">Foto Profil</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex flex-col items-center">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="h-32 w-32 rounded-full object-cover mb-4">
                            @else
                                <div class="h-32 w-32 rounded-full bg-secondary-200 flex items-center justify-center mb-4">
                                    <svg class="h-16 w-16 text-secondary-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                            <input wire:model="photo" type="file" class="form-input">
                            @error('photo') <span class="form-error">{{ $message }}</span> @enderror
                            <p class="text-xs text-secondary-500 mt-2">JPG, PNG. Max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-info-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-secondary-900">Informasi</h4>
                                <p class="text-sm text-secondary-600 mt-1">
                                    NIK akan digenerate otomatis. Password default: <strong>password</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col space-y-3">
                    <button type="submit" class="btn-primary w-full">
                        Simpan Karyawan
                    </button>
                    <a href="{{ route('employees.index') }}" wire:navigate class="btn-outline w-full text-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>