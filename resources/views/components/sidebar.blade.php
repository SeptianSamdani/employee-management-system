{{-- Modern Clean Sidebar with White Background --}}
<aside id="sidebar" class="sidebar sidebar-expanded bg-white flex-shrink-0 overflow-y-auto border-r border-gray-200 shadow-sm">
    <div class="flex flex-col h-full">
        <!-- Header with Brand -->
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="menu-text text-lg font-bold text-gray-900">EMS</span>
            </div>
            <button id="toggleSidebar" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- User Profile Card -->
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center space-x-3 p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl">
                @if(Auth::user()->employee && Auth::user()->employee->photo)
                    <img src="{{ Storage::url(Auth::user()->employee->photo) }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="w-11 h-11 rounded-lg object-cover border-2 border-white shadow-sm">
                @else
                    <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm shadow-sm border-2 border-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                @endif
                <div class="menu-text flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    @if(Auth::user()->roles->first())
                        <p class="text-xs text-gray-600 truncate flex items-center mt-0.5">
                            {{ ucfirst(Auth::user()->roles->first()->name) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
            <!-- Main Section -->
            <div class="mb-1">
                <p class="menu-text px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu Utama</p>
            </div>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('dashboard') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Dashboard</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('profile.index') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('profile.*') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Profil Saya</span>
            </a>

            @can('view employees')
            <!-- Karyawan -->
            <a href="{{ route('employees.index') }}"
                wire:navigate 
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('employees.*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('employees.*') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('employees.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Karyawan</span>
            </a>
            @endcan

            @can('view attendances')
            <!-- Absensi -->
            <a href="{{ route('attendance.index') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('attendance.index') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('attendance.index') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('attendance.index') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Absensi</span>
            </a>
            @endcan

            @can('view leaves')
            <!-- Cuti -->
            <a href="{{ route('leaves.index') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('leaves.index') || request()->routeIs('leaves.request') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('leaves.index') || request()->routeIs('leaves.request') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('leaves.index') || request()->routeIs('leaves.request') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Cuti</span>
            </a>
            @endcan

            <!-- Management Section -->
            @canany(['manage leave types', 'approve leaves', 'manage departments', 'manage positions', 'manage work schedules'])
                <div class="my-4 border-t border-gray-200"></div>
                <div class="mb-1">
                    <p class="menu-text px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen</p>
                </div>
            @endcanany

            @can('approve leaves')
            <!-- Approval Cuti -->
            <a href="{{ route('leaves.approval') }}" 
                wire:navigate
                class="menu-item flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('leaves.approval') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                        {{ request()->routeIs('leaves.approval') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('leaves.approval') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="menu-text text-sm font-medium">Approval</span>
                </div>
                @php
                    $pendingCount = \App\Models\Leave::where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="menu-text inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-sm">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
            @endcan

            @can('manage leave types')
            <!-- Tipe Cuti -->
            <a href="{{ route('leave-types.index') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('leave-types.*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('leave-types.*') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('leave-types.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Tipe Cuti</span>
            </a>
            @endcan
            
            @can('manage departments')
            <!-- Departemen -->
            <a href="{{ route('departments.index') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('departments.*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('departments.*') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('departments.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Departemen</span>
            </a>
            @endcan
            
            @can('manage positions')
            <!-- Posisi -->
            <a href="{{ route('positions.index') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('positions.*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('positions.*') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('positions.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Posisi</span>
            </a>
            @endcan
            
            @can('manage work schedules')
            <!-- Jadwal Kerja -->
            <a href="{{ route('work-schedules.index') }}"
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('work-schedules.*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('work-schedules.*') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('work-schedules.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Jadwal Kerja</span>
            </a>
            @endcan

            <!-- Quick Actions Section -->
            @can('check in')
                <div class="my-4 border-t border-gray-200"></div>
                <div class="mb-1">
                    <p class="menu-text px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi Cepat</p>
                </div>
                
                <!-- Check In -->
                <a href="{{ route('attendance.check-in') }}" 
                    wire:navigate
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                        {{ request()->routeIs('attendance.check-in') ? 'bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 shadow-sm ring-2 ring-green-200' : 'bg-gradient-to-r from-green-500 to-emerald-600 text-white hover:shadow-md' }}">
                    <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg {{ request()->routeIs('attendance.check-in') ? 'bg-white shadow-sm' : 'bg-white/20' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('attendance.check-in') ? 'text-green-600' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="menu-text text-sm font-semibold">Check In</span>
                </a>
            @endcan
            
            @role('employee')
            <!-- Riwayat Saya -->
            <a href="{{ route('attendance.history') }}" 
                wire:navigate
                class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group
                    {{ request()->routeIs('attendance.history') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 shadow-sm' : 'text-gray-700' }}">
                <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg 
                    {{ request()->routeIs('attendance.history') ? 'bg-white shadow-sm' : 'group-hover:bg-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('attendance.history') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <span class="menu-text text-sm font-medium">Riwayat Saya</span>
            </a>
            @endrole
        </nav>

        <!-- Footer with Logout -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-xl hover:bg-red-50 transition-all duration-200 w-full group text-gray-700 hover:text-red-600">
                    <div class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg group-hover:bg-white">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span class="menu-text text-sm font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
/* Smooth scrollbar untuk sidebar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
}

/* Smooth transitions */
.menu-item {
    position: relative;
    overflow: hidden;
}

/* Active indicator animation */
.menu-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 0;
    width: 3px;
    background: linear-gradient(180deg, #6366f1, #8b5cf6);
    border-radius: 0 3px 3px 0;
    transition: height 0.3s ease;
}

.menu-item.active::before {
    height: 70%;
}
</style>