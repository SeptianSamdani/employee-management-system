<div>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-secondary-900">Pengaturan Jadwal Kerja</h1>
        <p class="text-sm text-secondary-600 mt-1">Atur jadwal kerja per departemen</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-success-50 border border-success-200 text-success-800 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Department Selection -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold">Pilih Departemen</h3>
            </div>
            <div class="card-body">
                <div class="space-y-2">
                    @foreach($departments as $dept)
                        <button 
                            wire:click="$set('selectedDepartment', {{ $dept->id }})"
                            class="w-full text-left px-4 py-3 rounded-lg border transition {{ $selectedDepartment == $dept->id ? 'border-primary-500 bg-primary-50' : 'border-secondary-200 hover:border-secondary-300' }}">
                            <div class="font-medium">{{ $dept->name }}</div>
                            <div class="text-xs text-secondary-600">{{ $dept->code }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Schedule Form -->
        <div class="lg:col-span-2">
            @if($selectedDepartment)
                <form wire:submit="save">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="font-semibold">Jadwal Kerja</h3>
                        </div>
                        <div class="card-body space-y-6">
                            <!-- Check In Time -->
                            <div>
                                <label class="form-label">Jam Masuk <span class="text-danger-500">*</span></label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-secondary-600">Mulai</label>
                                        <input wire:model="check_in_start" type="time" class="form-input" required>
                                        @error('check_in_start') <span class="form-error">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="text-xs text-secondary-600">Batas Akhir</label>
                                        <input wire:model="check_in_end" type="time" class="form-input" required>
                                        @error('check_in_end') <span class="form-error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Check Out Time -->
                            <div>
                                <label class="form-label">Jam Pulang <span class="text-danger-500">*</span></label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-secondary-600">Mulai</label>
                                        <input wire:model="check_out_start" type="time" class="form-input" required>
                                        @error('check_out_start') <span class="form-error">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="text-xs text-secondary-600">Batas Akhir</label>
                                        <input wire:model="check_out_end" type="time" class="form-input" required>
                                        @error('check_out_end') <span class="form-error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Late Tolerance -->
                            <div>
                                <label class="form-label">Toleransi Keterlambatan (Menit) <span class="text-danger-500">*</span></label>
                                <input wire:model="late_tolerance_minutes" type="number" min="0" max="60" class="form-input" required>
                                @error('late_tolerance_minutes') <span class="form-error">{{ $message }}</span> @enderror
                                <p class="text-xs text-secondary-600 mt-1">Contoh: 15 menit setelah batas akhir check-in</p>
                            </div>

                            <!-- Work Days -->
                            <div>
                                <label class="form-label">Hari Kerja <span class="text-danger-500">*</span></label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach(['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'] as $day => $label)
                                        <label class="flex items-center space-x-2 p-2 border rounded hover:bg-secondary-50 cursor-pointer">
                                            <input 
                                                wire:model="work_days" 
                                                type="checkbox" 
                                                value="{{ $day }}"
                                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded">
                                            <span class="text-sm">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('work_days') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn-primary">
                                    Simpan Jadwal
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="card">
                    <div class="card-body text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-secondary-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-secondary-600">Pilih departemen untuk mengatur jadwal kerja</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>