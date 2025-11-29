<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-medium text-secondary-900">Ganti Password</h3>
    </div>
    <div class="card-body">
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-success-50 border border-success-200 text-success-800 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="updatePassword" class="max-w-xl">
            <div class="space-y-6">
                <!-- Current Password -->
                <div>
                    <label class="form-label">Password Lama <span class="text-danger-500">*</span></label>
                    <input wire:model="current_password" type="password" class="form-input" placeholder="Masukkan password lama" required autocomplete="current-password">
                    @error('current_password') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label class="form-label">Password Baru <span class="text-danger-500">*</span></label>
                    <input wire:model="new_password" type="password" class="form-input" placeholder="Masukkan password baru (min. 8 karakter)" required autocomplete="new-password">
                    @error('new_password') <span class="form-error">{{ $message }}</span> @enderror
                    <p class="text-xs text-secondary-600 mt-1">Minimal 8 karakter dan berbeda dengan password lama</p>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label class="form-label">Konfirmasi Password Baru <span class="text-danger-500">*</span></label>
                    <input wire:model="new_password_confirmation" type="password" class="form-input" placeholder="Ulangi password baru" required autocomplete="new-password">
                    @error('new_password_confirmation') <span class="form-error">{{ $message }}</span> @enderror>
                </div>

                <!-- Password Requirements -->
                <div class="bg-info-50 border border-info-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-info-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-info-800 mb-1">Persyaratan Password</h4>
                            <ul class="text-xs text-info-700 space-y-1">
                                <li>• Minimal 8 karakter</li>
                                <li>• Harus berbeda dengan password lama</li>
                                <li>• Kombinasi huruf dan angka lebih aman</li>
                                <li>• Jangan gunakan password yang mudah ditebak</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4 border-t">
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Ganti Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>