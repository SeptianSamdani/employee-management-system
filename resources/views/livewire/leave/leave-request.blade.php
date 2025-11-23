<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Ajukan Cuti</h1>
                <p class="text-sm text-secondary-600 mt-1">Buat pengajuan cuti baru</p>
            </div>
            <a href="{{ route('leaves.index') }}" wire:navigate class="btn-outline">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form wire:submit="submit">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-secondary-900">Informasi Cuti</h3>
                    </div>
                    <div class="card-body space-y-6">
                        <!-- Leave Type -->
                        <div>
                            <label class="form-label">Tipe Cuti <span class="text-danger-500">*</span></label>
                            <select wire:model.live="leave_type_id" class="form-input" required>
                                <option value="">Pilih Tipe Cuti</option>
                                @foreach($leaveTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }} (Max: {{ $type->max_days }} hari)</option>
                                @endforeach
                            </select>
                            @error('leave_type_id') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Tanggal Mulai <span class="text-danger-500">*</span></label>
                                <input wire:model.live="start_date" type="date" class="form-input" required>
                                @error('start_date') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="form-label">Tanggal Selesai <span class="text-danger-500">*</span></label>
                                <input wire:model.live="end_date" type="date" class="form-input" required>
                                @error('end_date') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Total Days Info -->
                        @if($totalDays > 0)
                        <div class="bg-info-50 border border-info-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-info-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-info-800">
                                    Total: <strong>{{ $totalDays }} hari kerja</strong> (tidak termasuk weekend)
                                </span>
                            </div>
                        </div>
                        @endif

                        <!-- Reason -->
                        <div>
                            <label class="form-label">Alasan Cuti <span class="text-danger-500">*</span></label>
                            <textarea wire:model="reason" rows="4" class="form-input" placeholder="Jelaskan alasan pengajuan cuti..." required></textarea>
                            @error('reason') <span class="form-error">{{ $message }}</span> @enderror
                            <p class="text-xs text-secondary-600 mt-1">Minimal 10 karakter</p>
                        </div>

                        <!-- Attachment -->
                        <div>
                            <label class="form-label">Lampiran (Opsional)</label>
                            <input wire:model="attachment" type="file" class="form-input">
                            @error('attachment') <span class="form-error">{{ $message }}</span> @enderror
                            <p class="text-xs text-secondary-600 mt-1">PDF, JPG, PNG. Max 2MB</p>
                            
                            @if ($attachment)
                                <div class="mt-2 text-sm text-success-600">
                                    File dipilih: {{ $attachment->getClientOriginalName() }}
                                </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            <a href="{{ route('leaves.index') }}" wire:navigate class="btn-outline">
                                Batal
                            </a>
                            <button type="submit" class="btn-primary">
                                Ajukan Cuti
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Balance Info -->
            @if($selectedLeaveType)
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold">Sisa Kuota</h3>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">
                            {{ $remainingBalance }}
                        </div>
                        <p class="text-sm text-secondary-600">hari tersisa</p>
                        <div class="mt-4 pt-4 border-t text-xs text-secondary-500">
                            <div class="flex justify-between mb-1">
                                <span>Total:</span>
                                <span class="font-medium">{{ $selectedLeaveType->max_days }} hari</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Terpakai:</span>
                                <span class="font-medium">{{ $selectedLeaveType->max_days - $remainingBalance }} hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Leave Type Info -->
            @if($selectedLeaveType)
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold">Informasi Tipe Cuti</h3>
                </div>
                <div class="card-body space-y-3 text-sm">
                    <div>
                        <p class="text-secondary-600">Nama</p>
                        <p class="font-semibold">{{ $selectedLeaveType->name }}</p>
                    </div>
                    <div>
                        <p class="text-secondary-600">Maksimal</p>
                        <p class="font-semibold">{{ $selectedLeaveType->max_days }} hari/tahun</p>
                    </div>
                    <div>
                        <p class="text-secondary-600">Status Gaji</p>
                        @if($selectedLeaveType->is_paid)
                            <span class="badge-success">Dibayar</span>
                        @else
                            <span class="badge-warning">Tidak Dibayar</span>
                        @endif
                    </div>
                    @if($selectedLeaveType->description)
                    <div>
                        <p class="text-secondary-600 mb-1">Deskripsi</p>
                        <p class="text-xs text-secondary-700">{{ $selectedLeaveType->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Guidelines -->
            <div class="card">
                <div class="card-body text-sm text-secondary-600">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-warning-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-secondary-900 mb-2">Panduan</h4>
                            <ul class="space-y-1 text-xs">
                                <li>• Ajukan cuti minimal 3 hari sebelumnya</li>
                                <li>• Sertakan surat dokter untuk cuti sakit</li>
                                <li>• Pastikan pekerjaan sudah terdelegasi</li>
                                <li>• Tunggu approval dari atasan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>