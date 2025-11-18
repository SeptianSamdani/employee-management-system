<!DOCTYPE html>
<html lang="id" class="h-full bg-secondary-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - EMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Navbar -->
        <nav class="bg-white border-b border-secondary-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-xl font-bold text-primary-600">EMS</span>
                        </div>
                        <div class="hidden sm:ml-8 sm:flex sm:space-x-1">
                            <a href="{{ route('dashboard') }}" 
                               class="@if(request()->routeIs('dashboard')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Dashboard
                            </a>
                            @can('view employees')
                            <a href="{{ route('employees.index') }}" 
                               class="@if(request()->routeIs('employees.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Karyawan
                            </a>
                            @endcan
                            @can('view attendances')
                            <a href="{{ route('attendance.index') }}" 
                               class="@if(request()->routeIs('attendance.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Absensi
                            </a>
                            @endcan
                            @can('view leaves')
                            {{-- <a href="{{ route('leaves.index') }}" 
                               class="@if(request()->routeIs('leaves.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Cuti
                            </a> --}}
                            @endcan
                            @role('admin|hr')
                            {{-- <a href="{{ route('payroll.index') }}" 
                               class="@if(request()->routeIs('payroll.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Payroll
                            </a> --}}
                            @endrole
                            @role('admin|hr')
                            <a href="{{ route('departments.index') }}" 
                            class="@if(request()->routeIs('departments.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Departemen
                            </a>
                            <a href="{{ route('positions.index') }}" 
                            class="@if(request()->routeIs('positions.*')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Posisi
                            </a>
                            @endrole
                            @role('employee')
                            <a href="{{ route('attendance.check-in') }}" 
                            class="@if(request()->routeIs('attendance.check-in')) border-primary-500 text-secondary-900 @else border-transparent text-secondary-500 hover:border-secondary-300 hover:text-secondary-700 @endif inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium">
                                Check In
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
                            <button type="submit" class="text-sm text-secondary-600 hover:text-secondary-900">
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
</body>
</html>