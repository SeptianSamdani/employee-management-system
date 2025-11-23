<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Check In/Out Card -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-2xl font-bold mb-6">Absensi Hari Ini</h2>
                    
                    @if(session()->has('message'))
                        <div class="bg-success-50 p-4 rounded-lg mb-4">
                            <p class="text-success-800">{{ session('message') }}</p>
                        </div>
                    @endif
                    
                    @if(session()->has('error'))
                        <div class="bg-danger-50 p-4 rounded-lg mb-4">
                            <p class="text-danger-800">{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    <div class="mb-6">
                        <p class="text-secondary-600">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                        <p class="text-4xl font-bold text-primary-600" id="clock"></p>
                    </div>
                    
                    @if($todayAttendance)
                        <div class="mb-6 p-4 bg-secondary-50 rounded-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-secondary-600">Check In</p>
                                    <p class="font-semibold text-lg">{{ $todayAttendance->check_in }}</p>
                                    @if($todayAttendance->is_late)
                                        <span class="badge-warning">Terlambat {{ $todayAttendance->late_minutes }} menit</span>
                                    @else
                                        <span class="badge-success">Tepat Waktu</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-secondary-600">Check Out</p>
                                    <p class="font-semibold text-lg">{{ $todayAttendance->check_out ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="space-y-4">
                        @if(!$todayAttendance)
                            <button wire:click="checkIn" class="btn-primary w-full py-4 text-lg">
                                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Check In
                            </button>
                        @elseif(!$todayAttendance->check_out)
                            <button wire:click="checkOut" class="btn-danger w-full py-4 text-lg">
                                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Check Out
                            </button>
                        @else
                            <div class="p-4 bg-success-50 rounded-lg">
                                <p class="text-success-800">Anda sudah menyelesaikan absensi hari ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Schedule Info -->
        <div class="space-y-6">
            @if($schedule)
                <div class="card">
                    <div class="card-header">
                        <h3 class="font-semibold">Jadwal Kerja</h3>
                    </div>
                    <div class="card-body space-y-3 text-sm">
                        <div>
                            <p class="text-secondary-600">Jam Masuk</p>
                            <p class="font-semibold">{{ substr($schedule->check_in_start, 0, 5) }} - {{ substr($schedule->check_in_end, 0, 5) }}</p>
                        </div>
                        <div>
                            <p class="text-secondary-600">Jam Pulang</p>
                            <p class="font-semibold">{{ substr($schedule->check_out_start, 0, 5) }} - {{ substr($schedule->check_out_end, 0, 5) }}</p>
                        </div>
                        <div>
                            <p class="text-secondary-600">Toleransi Keterlambatan</p>
                            <p class="font-semibold">{{ $schedule->late_tolerance_minutes }} menit</p>
                        </div>
                        <div>
                            <p class="text-secondary-600 mb-1">Hari Kerja</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                    <span class="badge {{ in_array($day, $schedule->work_days) ? 'badge-primary' : 'badge-secondary' }}">
                                        {{ ucfirst(substr($day, 0, 3)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body text-sm text-secondary-600">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-info-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-medium text-secondary-900 mb-1">Informasi</p>
                            <ul class="space-y-1 text-xs">
                                <li>• Pastikan GPS aktif</li>
                                <li>• Check-in hanya bisa dilakukan pada hari kerja</li>
                                <li>• Toleransi keterlambatan sesuai jadwal</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Get GPS location
        navigator.geolocation.getCurrentPosition(
            (position) => {
                @this.set('latitude', position.coords.latitude);
                @this.set('longitude', position.coords.longitude);
            },
            (error) => {
                console.error('GPS Error:', error);
            }
        );
        
        // Live clock
        setInterval(() => {
            const clock = document.getElementById('clock');
            if (clock) {
                clock.textContent = new Date().toLocaleTimeString('id-ID');
            }
        }, 1000);
    </script>
</div>