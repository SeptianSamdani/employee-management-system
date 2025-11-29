<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Edit Profil</h1>
                <p class="text-sm text-secondary-600 mt-1">Perbarui informasi kontak Anda</p>
            </div>
            <a href="{{ route('profile.index') }}" wire:navigate class="btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form wire:submit="update">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-secondary-900">Informasi yang Dapat Diubah</h3>
                    </div>
                    <div class="card-body space-y-6">
                        <!-- Phone -->
                        <div>
                            <label class="form-label">No. Telepon</label>
                            <input wire:model="phone" type="text" class="form-input" placeholder="08123456789">
                            @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="form-label">Alamat</label>
                            <textarea wire:model="address" rows="4" class="form-input" placeholder="Masukkan alamat lengkap..."></textarea>
                            @error('address') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            <a href="{{ route('profile.index') }}" wire:navigate class="btn-outline">
                                Batal
                            </a>
                            <button type="submit" class="btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
                            <img src="{{ $photo->temporaryUrl() }}" class="h-32 w-32 rounded-full object-cover mb-4 border-4 border-secondary-100">
                        @elseif ($existing_photo)
                            <img src="{{ Storage::url($existing_photo) }}" class="h-32 w-32 rounded-full object-cover mb-4 border-4 border-secondary-100">
                        @else
                            <div class="h-32 w-32 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mb-4 border-4 border-secondary-100">
                                <span class="text-4xl font-bold text-white">{{ strtoupper(substr($employee->full_name, 0, 2)) }}</span>
                            </div>
                        @endif
                        
                        <input wire:model="photo" type="file" class="form-input">
                        @error('photo') <span class="form-error">{{ $message }}</span> @enderror
                        <p class="text-xs text-secondary-500 mt-2 text-center">JPG, PNG. Maksimal 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-info-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-secondary-900 mb-2">Informasi</h4>
                            <ul class="text-xs text-secondary-600 space-y-1">
                                <li>• Anda hanya dapat mengubah informasi kontak</li>
                                <li>• Untuk perubahan data lain, hubungi HR</li>
                                <li>• Foto profil akan diupdate otomatis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Read-only Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-medium text-secondary-700">Data Tetap</h3>
                </div>
                <div class="card-body">
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-secondary-600">NIK</dt>
                            <dd class="font-medium text-secondary-900">{{ $employee->employee_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-secondary-600">Email</dt>
                            <dd class="font-medium text-secondary-900">{{ $employee->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-secondary-600">Departemen</dt>
                            <dd class="font-medium text-secondary-900">{{ $employee->department->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-secondary-600">Posisi</dt>
                            <dd class="font-medium text-secondary-900">{{ $employee->position->name }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>