<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary-50 antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-900 to-primary-800 p-12 flex-col justify-between relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute transform rotate-45 -right-64 -top-64 w-96 h-96 bg-white rounded-full"></div>
                <div class="absolute transform rotate-45 -left-32 -bottom-32 w-64 h-64 bg-white rounded-full"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10">
                <div class="flex items-center space-x-3 mb-16">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-semibold text-white">EMS</span>
                </div>
                
                <div class="max-w-md">
                    <h1 class="text-4xl font-bold text-white mb-4 leading-tight">
                        Employee Management System
                    </h1>
                    <p class="text-lg text-secondary-300 leading-relaxed">
                        Sistem manajemen karyawan yang modern, efisien, dan terintegrasi untuk perusahaan Anda.
                    </p>
                </div>
            </div>

            <!-- Features -->
            <div class="relative z-10 space-y-4">
                <div class="flex items-center space-x-3 text-secondary-300">
                    <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-sm">Manajemen Karyawan & Departemen</span>
                </div>
                <div class="flex items-center space-x-3 text-secondary-300">
                    <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-sm">Sistem Absensi Real-time</span>
                </div>
                <div class="flex items-center space-x-3 text-secondary-300">
                    <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-sm">Laporan & Analytics Lengkap</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex-1 flex items-center justify-center p-8 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center mb-8">
                    <div class="w-12 h-12 bg-secondary-900 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-secondary-900 mb-2">Welcome back</h2>
                    <p class="text-secondary-600">Silakan masuk untuk melanjutkan</p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-100 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-secondary-700 mb-2">
                            Email
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email"
                            required 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-white border border-secondary-300 rounded-lg text-secondary-900 placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-secondary-900 focus:border-transparent transition duration-200"
                            placeholder="nama@perusahaan.com">
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-secondary-700 mb-2">
                            Password
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="current-password"
                            required 
                            class="w-full px-4 py-3 bg-white border border-secondary-300 rounded-lg text-secondary-900 placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-secondary-900 focus:border-transparent transition duration-200"
                            placeholder="••••••••">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="w-4 h-4 text-secondary-900 border-secondary-300 rounded focus:ring-secondary-900">
                        <label for="remember" class="ml-2 block text-sm text-secondary-600">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-secondary-900 hover:bg-secondary-800 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-900 transition duration-200">
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-secondary-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-secondary-50 text-secondary-500">Demo Accounts</span>
                    </div>
                </div>

                <!-- Demo Accounts -->
                <div class="grid grid-cols-2 gap-3">
                    <button 
                        type="button"
                        onclick="fillLogin('admin@example.com', 'password')"
                        class="group p-4 bg-white border border-secondary-200 rounded-lg hover:border-secondary-400 hover:shadow-sm transition duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-secondary-500 uppercase tracking-wide">Admin</span>
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-secondary-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <p class="text-xs text-secondary-600 truncate">admin@example.com</p>
                    </button>

                    <button 
                        type="button"
                        onclick="fillLogin('hr@example.com', 'password')"
                        class="group p-4 bg-white border border-secondary-200 rounded-lg hover:border-secondary-400 hover:shadow-sm transition duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-secondary-500 uppercase tracking-wide">HR</span>
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-secondary-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <p class="text-xs text-secondary-600 truncate">hr@example.com</p>
                    </button>

                    <button 
                        type="button"
                        onclick="fillLogin('manager@example.com', 'password')"
                        class="group p-4 bg-white border border-secondary-200 rounded-lg hover:border-secondary-400 hover:shadow-sm transition duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-secondary-500 uppercase tracking-wide">Manager</span>
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-secondary-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <p class="text-xs text-secondary-600 truncate">manager@example.com</p>
                    </button>

                    <button 
                        type="button"
                        onclick="fillLogin('employee@example.com', 'password')"
                        class="group p-4 bg-white border border-secondary-200 rounded-lg hover:border-secondary-400 hover:shadow-sm transition duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-secondary-500 uppercase tracking-wide">Employee</span>
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-secondary-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <p class="text-xs text-secondary-600 truncate">employee@example.com</p>
                    </button>
                </div>

                <p class="text-xs text-center text-secondary-500 mt-4">
                    Klik untuk auto-fill • Password: <span class="font-medium text-secondary-700">password</span>
                </p>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-secondary-200">
                    <p class="text-xs text-center text-secondary-500">
                        © {{ date('Y') }} Employee Management System
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillLogin(email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            emailInput.value = email;
            passwordInput.value = password;
            
            // Smooth focus animation
            emailInput.focus();
            emailInput.classList.add('ring-2', 'ring-secondary-900');
            
            setTimeout(() => {
                passwordInput.focus();
                passwordInput.classList.add('ring-2', 'ring-secondary-900');
            }, 200);
            
            setTimeout(() => {
                emailInput.classList.remove('ring-2', 'ring-secondary-900');
                passwordInput.classList.remove('ring-2', 'ring-secondary-900');
            }, 1000);
        }

        // Auto-focus email on load
        window.addEventListener('load', () => {
            document.getElementById('email')?.focus();
        });

        // Enter key handling
        document.getElementById('email')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('password')?.focus();
            }
        });
    </script>
</body>
</html>