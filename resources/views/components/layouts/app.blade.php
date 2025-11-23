<!DOCTYPE html>
<html lang="id" class="h-full bg-secondary-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - EMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .loading-overlay.active {
            display: flex;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f4f6;
            border-top-color: #9333ea;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Top loading bar */
        .top-loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #9333ea, #a855f7);
            z-index: 10000;
            transition: width 0.3s ease;
            width: 0%;
        }
        
        .top-loading-bar.loading {
            width: 90%;
        }
        
        .top-loading-bar.complete {
            width: 100%;
            transition: width 0.2s ease, opacity 0.3s ease;
        }
        
        .top-loading-bar.complete {
            opacity: 0;
        }
    </style>
</head>
<body class="h-full">
    
    <!-- Top Loading Bar -->
    <div id="topLoadingBar" class="top-loading-bar"></div>
    
    <!-- Loading Overlay (Optional) -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
    </div>

    <div class="min-h-full">
        <!-- Navbar -->
        <nav class="bg-white border-b border-secondary-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-primary-600 hover:text-primary-700 transition nav-link">
                                EMS
                            </a>
                        </div>
                        <div class="hidden sm:ml-8 sm:flex sm:space-x-1">
                            <a href="{{ route('dashboard') }}" 
                               class="nav-link @if(request()->routeIs('dashboard')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Dashboard
                            </a>
                            
                            @can('view employees')
                            <a href="{{ route('employees.index') }}" 
                               class="nav-link @if(request()->routeIs('employees.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Karyawan
                            </a>
                            @endcan
                            
                            @can('view attendances')
                            <a href="{{ route('attendance.index') }}" 
                               class="nav-link @if(request()->routeIs('attendance.index')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Absensi
                            </a>
                            @endcan
                            
                            @role('admin|hr')
                            <a href="{{ route('departments.index') }}" 
                               class="nav-link @if(request()->routeIs('departments.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Departemen
                            </a>
                            
                            <a href="{{ route('positions.index') }}" 
                               class="nav-link @if(request()->routeIs('positions.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Posisi
                            </a>
                            
                            <a href="{{ route('work-schedules.index') }}" 
                               class="nav-link @if(request()->routeIs('work-schedules.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Jadwal Kerja
                            </a>
                            @endrole
                            
                            @role('employee')
                            <a href="{{ route('attendance.check-in') }}" 
                               class="nav-link @if(request()->routeIs('attendance.check-in')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Check In
                            </a>
                            
                            <a href="{{ route('attendance.history') }}" 
                               class="nav-link @if(request()->routeIs('attendance.history')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition">
                                Riwayat Saya
                            </a>
                            @endrole
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-sm">
                            <span class="text-secondary-600">{{ Auth::user()->name }}</span>
                            <span class="badge-primary ml-2">{{ Auth::user()->roles->first()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-secondary-600 hover:text-secondary-900 transition">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    
    <script>
        // Show loading bar on navigation
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const topBar = document.getElementById('topLoadingBar');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Show loading bar
                    topBar.classList.add('loading');
                    
                    // Simulate progress
                    setTimeout(() => {
                        topBar.classList.remove('loading');
                        topBar.classList.add('complete');
                        
                        setTimeout(() => {
                            topBar.classList.remove('complete');
                            topBar.style.width = '0%';
                        }, 300);
                    }, 500);
                });
            });
        });
    </script>
</body>
</html>