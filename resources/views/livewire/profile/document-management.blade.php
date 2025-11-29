<div>
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
        <div class="card-header flex justify-between items-center">
            <h3 class="text-lg font-medium text-secondary-900">Dokumen Saya</h3>
            <button wire:click="openModal" class="btn-primary btn-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload Dokumen
            </button>
        </div>
        <div class="card-body">
            @if($documents->count() > 0)
                <div class="space-y-3">
                    @foreach($documents as $doc)
                        <div class="flex items-center justify-between p-4 border border-secondary-200 rounded-lg hover:bg-secondary-50 transition-colors">
                            <div class="flex items-center space-x-4 flex-1">
                                <!-- File Icon -->
                                <div class="flex-shrink-0">
                                    @if($doc->file_type === 'pdf')
                                        <div class="w-12 h-12 bg-danger-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-danger-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Document Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <h4 class="text-sm font-medium text-secondary-900 truncate">{{ $doc->title }}</h4>
                                        <span class="badge-secondary text-xs">{{ $doc->type_name }}</span>
                                        @if($doc->is_verified)
                                            <span class="badge-success text-xs">Terverifikasi</span>
                                        @else
                                            <span class="badge-warning text-xs">Pending</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-3 text-xs text-secondary-500">
                                        <span>{{ $doc->file_size_formatted }}</span>
                                        <span>•</span>
                                        <span>{{ $doc->created_at->format('d M Y') }}</span>
                                        @if($doc->expiry_date)
                                            <span>•</span>
                                            @if($doc->is_expired)
                                                <span class="text-danger-600 font-medium">Kadaluarsa: {{ $doc->expiry_date->format('d M Y') }}</span>
                                            @elseif($doc->is_expiring_soon)
                                                <span class="text-warning-600 font-medium">Berlaku hingga: {{ $doc->expiry_date->format('d M Y') }}</span>
                                            @else
                                                <span>Berlaku hingga: {{ $doc->expiry_date->format('d M Y') }}</span>
                                            @endif
                                        @endif
                                    </div>
                                    @if($doc->description)
                                        <p class="text-xs text-secondary-600 mt-1 line-clamp-1">{{ $doc->description }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2 ml-4">
                                <button wire:click="download({{ $doc->id }})" class="p-2 text-primary-600 hover:bg-primary-50 rounded transition-colors" title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $doc->id }})" wire:confirm="Yakin ingin menghapus dokumen ini?" class="p-2 text-danger-600 hover:bg-danger-50 rounded transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-secondary-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-secondary-600 mb-4">Belum ada dokumen yang diunggah</p>
                    <button wire:click="openModal" class="btn-primary">
                        Upload Dokumen Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center px-4">
            <div class="fixed inset-0 bg-secondary-900 bg-opacity-50 transition-opacity" wire:click="closeModal"></div>
            
            <div class="relative bg-white rounded-lg max-w-lg w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-secondary-900">Upload Dokumen</h3>
                    <button wire:click="closeModal" class="text-secondary-400 hover:text-secondary-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="upload" class="space-y-4">
                    <div>
                        <label class="form-label">Tipe Dokumen <span class="text-danger-500">*</span></label>
                        <select wire:model="type" class="form-input" required>
                            <option value="">Pilih Tipe</option>
                            @foreach($documentTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label">Judul Dokumen <span class="text-danger-500">*</span></label>
                        <input wire:model="title" type="text" class="form-input" placeholder="e.g. KTP Atas Nama John Doe" required>
                        @error('title') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea wire:model="description" rows="3" class="form-input" placeholder="Keterangan tambahan..."></textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label">Tanggal Kedaluwarsa (Opsional)</label>
                        <input wire:model="expiry_date" type="date" class="form-input">
                        @error('expiry_date') <span class="form-error">{{ $message }}</span> @enderror
                        <p class="text-xs text-secondary-600 mt-1">Untuk dokumen dengan masa berlaku (e.g. BPJS, Sertifikat)</p>
                    </div>

                    <div>
                        <label class="form-label">File Dokumen <span class="text-danger-500">*</span></label>
                        <input wire:model="file" type="file" class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        @error('file') <span class="form-error">{{ $message }}</span> @enderror
                        <p class="text-xs text-secondary-600 mt-1">PDF, JPG, JPEG, PNG. Maksimal 5MB</p>
                        
                        @if ($file)
                            <div class="mt-2 text-sm text-success-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                File dipilih: {{ $file->getClientOriginalName() }}
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button type="button" wire:click="closeModal" class="btn-outline">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>