<div class="max-w-md mx-auto">
    <div class="card">
        <div class="card-body text-center">
            <h2 class="text-2xl font-bold mb-6">Absensi Hari Ini</h2>
            
            @if($status === 'success')
                <div class="bg-success-50 p-4 rounded-lg mb-4">
                    <p class="text-success-800">{{ session('message') }}</p>
                </div>
            @endif
            
            <div class="mb-6">
                <p class="text-secondary-600">{{ now()->format('l, d F Y') }}</p>
                <p class="text-4xl font-bold text-primary-600" id="clock"></p>
            </div>
            
            <div class="space-y-4">
                <button wire:click="checkIn" class="btn-primary w-full py-4 text-lg">
                    Check In
                </button>
                <button wire:click="checkOut" class="btn-secondary w-full py-4 text-lg">
                    Check Out
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Get GPS location
        navigator.geolocation.getCurrentPosition(
            (position) => {
                @this.set('latitude', position.coords.latitude);
                @this.set('longitude', position.coords.longitude);
            }
        );
        
        // Live clock
        setInterval(() => {
            document.getElementById('clock').textContent = 
                new Date().toLocaleTimeString('id-ID');
        }, 1000);
    </script>
</div>