{{-- resources/views/components/sidebar.blade.php --}}
<aside id="sidebar" class="sidebar sidebar-expanded bg-gradient-to-b from-primary-900 via-primary-800 to-primary-900 text-white flex-shrink-0 overflow-y-auto shadow-2xl">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-primary-700/50">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="menu-text text-xl font-bold">EMS</span>
            </div>
            <button id="toggleSidebar" class="p-2 hover:bg-primary-700/50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- User Info -->
        <div class="p-4 border-b border-primary-700/50">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-300 to-primary-500 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="menu-text flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                    @if(Auth::user()->roles->first())
                        <p class="text-xs text-primary-300 truncate">{{ ucfirst(Auth::user()->roles->first()->name) }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-3 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('dashboard')) active bg-primary-700/70 @endif group">
                <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="menu-text text-sm font-medium">Dashboard</span>
            </a>

            @can('view employees')
                <!-- Karyawan -->
                <a href="{{ route('employees.index') }}"
                    wire:navigate 
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('employees.*')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Karyawan</span>
                </a>
            @endcan
            
            @can('view attendances')
                <!-- Absensi -->
                <a href="{{ route('attendance.index') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('attendance.index')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Absensi</span>
                </a>
            @endcan

            @can('view leaves')
                <!-- Cuti -->
                <a href="{{ route('leaves.index') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('leaves.index') || request()->routeIs('leaves.request')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Cuti</span>
                </a>
            @endcan

            <!-- Divider -->
            @canany(['manage leave types', 'approve leaves', 'manage departments', 'manage positions', 'manage work schedules'])
                <div class="my-3 border-t border-primary-700/50"></div>
                <p class="menu-text px-3 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-2">Manajemen</p>
            @endcanany

            @can('approve leaves')
                <!-- Approval Cuti -->
                <a href="{{ route('leaves.approval') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('leaves.approval')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Approval Cuti</span>
                    @php
                        $pendingCount = \App\Models\Leave::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="menu-text ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-primary-900 bg-warning-400 rounded-full">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            @endcan

            @can('manage leave types')
                <!-- Tipe Cuti -->
                <a href="{{ route('leave-types.index') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('leave-types.*')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Tipe Cuti</span>
                </a>
            @endcan
            
            @can('manage departments')
                <!-- Departemen -->
                <a href="{{ route('departments.index') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('departments.*')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Departemen</span>
                </a>
            @endcan
            
            @can('manage positions')
                <!-- Posisi -->
                <a href="{{ route('positions.index') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('positions.*')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Posisi</span>
                </a>
            @endcan
            
            @can('manage work schedules')
                <!-- Jadwal Kerja -->
                <a href="{{ route('work-schedules.index') }}"
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('work-schedules.*')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Jadwal Kerja</span>
                </a>
            @endcan

            <!-- Employee Menu -->
            @can('check in')
                <div class="my-3 border-t border-primary-700/50"></div>
                <p class="menu-text px-3 text-xs font-semibold text-primary-300 uppercase tracking-wider mb-2">Aksi Cepat</p>
                
                <!-- Check In -->
                <a href="{{ route('attendance.check-in') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-success-600 bg-success-700/50 transition-all duration-200 @if(request()->routeIs('attendance.check-in')) active ring-2 ring-success-400 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Check In</span>
                </a>
            @endcan
            
            @role('employee')
                <!-- Riwayat Saya -->
                <a href="{{ route('attendance.history') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-primary-700/50 transition-all duration-200 @if(request()->routeIs('attendance.history')) active bg-primary-700/70 @endif group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Riwayat Saya</span>
                </a>
            @endrole
        </nav>

        <!-- Footer / Logout -->
        <div class="p-3 border-t border-primary-700/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-danger-600/50 transition-all duration-200 w-full group">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="menu-text text-sm font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>