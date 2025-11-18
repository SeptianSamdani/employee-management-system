<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-secondary-900">Dashboard</h1>
        <p class="text-sm text-secondary-600 mt-1">Ringkasan data karyawan dan kehadiran</p>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Karyawan -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-primary-100 rounded-lg">
                            <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary-600">Total Karyawan</p>
                        <p class="text-2xl font-semibold text-secondary-900">{{ $stats['total_employees'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-success-100 rounded-lg">
                            <svg class="h-6 w-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary-600">Hadir Hari Ini</p>
                        <p class="text-2xl font-semibold text-secondary-900">{{ $stats['present_today'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuti Pending -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-warning-100 rounded-lg">
                            <svg class="h-6 w-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary-600">Cuti Pending</p>
                        <p class="text-2xl font-semibold text-secondary-900">{{ $stats['pending_leaves'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sedang Cuti -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-info-100 rounded-lg">
                            <svg class="h-6 w-6 text-info-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary-600">Sedang Cuti</p>
                        <p class="text-2xl font-semibold text-secondary-900">{{ $stats['on_leave_today'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>