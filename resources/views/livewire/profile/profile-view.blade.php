<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-secondary-900">Profil Saya</h1>
                <p class="text-sm text-secondary-600 mt-1">Kelola informasi profil dan dokumen Anda</p>
            </div>
            <a href="{{ route('profile.edit') }}" wire:navigate class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profil
            </a>
        </div>
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

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    @if($employee->photo)
                        <img src="{{ Storage::url($employee->photo) }}" alt="{{ $employee->full_name }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-secondary-100">
                    @else
                        <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center border-4 border-secondary-100">
                            <span class="text-4xl font-bold text-white">{{ strtoupper(substr($employee->full_name, 0, 2)) }}</span>
                        </div>
                    @endif
                    
                    <h3 class="text-lg font-semibold text-secondary-900">{{ $employee->full_name }}</h3>
                    <p class="text-sm text-secondary-600">{{ $employee->employee_number }}</p>
                    <p class="text-sm text-secondary-500">{{ $employee->position->name }}</p>
                    
                    <div class="mt-4 pt-4 border-t">
                        @if($employee->status === 'active')
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Tidak Aktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="card">
                <div class="card-body p-0">
                    <nav class="flex flex-col">
                        <button 
                            wire:click="setActiveTab('info')"
                            class="flex items-center px-4 py-3 text-sm font-medium border-l-4 transition-colors {{ $activeTab === 'info' ? 'border-primary-600 bg-primary-50 text-primary-700' : 'border-transparent text-secondary-600 hover:bg-secondary-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informasi Pribadi
                        </button>
                        
                        <button 
                            wire:click="setActiveTab('documents')"
                            class="flex items-center px-4 py-3 text-sm font-medium border-l-4 transition-colors {{ $activeTab === 'documents' ? 'border-primary-600 bg-primary-50 text-primary-700' : 'border-transparent text-secondary-600 hover:bg-secondary-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Dokumen
                        </button>
                        
                        <button 
                            wire:click="setActiveTab('password')"
                            class="flex items-center px-4 py-3 text-sm font-medium border-l-4 transition-colors {{ $activeTab === 'password' ? 'border-primary-600 bg-primary-50 text-primary-700' : 'border-transparent text-secondary-600 hover:bg-secondary-50' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Ganti Password
                        </button>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            @if($activeTab === 'info')
                @include('livewire.profile.partials.info-tab')
            @elseif($activeTab === 'documents')
                @livewire('profile.document-management')
            @elseif($activeTab === 'password')
                @livewire('profile.change-password')
            @endif
        </div>
    </div>
</div>