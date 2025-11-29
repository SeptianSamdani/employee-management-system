<div class="space-y-6">
    <!-- Personal Information -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-medium text-secondary-900">Informasi Pribadi</h3>
        </div>
        <div class="card-body">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Nama Lengkap</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->full_name }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">NIK Karyawan</dt>
                    <dd class="mt-1 text-sm text-secondary-900 font-medium">{{ $employee->employee_number }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Email</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->email }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">No. Telepon</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->phone ?? '-' }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Tanggal Lahir</dt>
                    <dd class="mt-1 text-sm text-secondary-900">
                        {{ $employee->date_of_birth ? $employee->date_of_birth->format('d F Y') : '-' }}
                    </dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Jenis Kelamin</dt>
                    <dd class="mt-1 text-sm text-secondary-900">
                        {{ $employee->gender === 'male' ? 'Laki-laki' : ($employee->gender === 'female' ? 'Perempuan' : '-') }}
                    </dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">No. KTP</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->identity_number ?? '-' }}</dd>
                </div>
                
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-secondary-600">Alamat</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->address ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Employment Information -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-medium text-secondary-900">Informasi Kepegawaian</h3>
        </div>
        <div class="card-body">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Departemen</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->department->name }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Posisi</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->position->name }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Tanggal Bergabung</dt>
                    <dd class="mt-1 text-sm text-secondary-900">{{ $employee->join_date->format('d F Y') }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Masa Kerja</dt>
                    <dd class="mt-1 text-sm text-secondary-900">
                        {{ $employee->join_date->diffForHumans(['parts' => 2]) }}
                    </dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Status Kepegawaian</dt>
                    <dd class="mt-1">
                        @if($employee->employment_status === 'permanent')
                            <span class="badge-success">Tetap</span>
                        @elseif($employee->employment_status === 'contract')
                            <span class="badge-warning">Kontrak</span>
                        @else
                            <span class="badge-info">Magang</span>
                        @endif
                    </dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-secondary-600">Status Karyawan</dt>
                    <dd class="mt-1">
                        @if($employee->status === 'active')
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Tidak Aktif</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Document Completeness -->
    @php
        $completeness = $employee->document_completeness;
    @endphp
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-medium text-secondary-900">Kelengkapan Dokumen</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-secondary-700">Progress</span>
                    <span class="text-sm font-medium text-secondary-900">{{ $completeness['completed'] }}/{{ $completeness['total'] }} Dokumen</span>
                </div>
                <div class="w-full bg-secondary-200 rounded-full h-3">
                    <div class="h-3 rounded-full transition-all {{ $completeness['percentage'] == 100 ? 'bg-success-600' : 'bg-warning-500' }}" 
                         style="width: {{ $completeness['percentage'] }}%"></div>
                </div>
            </div>

            @if(count($completeness['missing']) > 0)
                <div class="bg-warning-50 border border-warning-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-warning-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-warning-800 mb-1">Dokumen yang Belum Lengkap</h4>
                            <ul class="text-xs text-warning-700 space-y-1">
                                @foreach($completeness['missing'] as $missing)
                                    <li>• {{ ucwords(str_replace('_', ' ', $missing)) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-success-50 border border-success-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-success-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-success-800">Semua dokumen wajib sudah lengkap</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>