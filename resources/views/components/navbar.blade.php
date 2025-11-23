{{-- resources/views/components/navbar.blade.php --}}
<header class="bg-white shadow-sm border-b border-secondary-200 z-10">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Page Title -->
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-bold text-secondary-900">
                    {{ $title ?? 'Dashboard' }}
                </h1>
            </div>

            <!-- Right Side Items -->
            <div class="flex items-center space-x-4">
                <!-- Notification Badge (Optional) -->
                @can('approve leaves')
                    @php
                        $pendingLeaves = \App\Models\Leave::where('status', 'pending')->count();
                    @endphp
                    @if($pendingLeaves > 0)
                        <a href="{{ route('leaves.approval') }}" 
                            wire:navigate
                            class="relative p-2 text-secondary-400 hover:text-secondary-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-danger-600 rounded-full">
                                {{ $pendingLeaves }}
                            </span>
                        </a>
                    @endif
                @endcan

                <!-- Current Date & Time -->
                <div class="hidden md:flex items-center space-x-2 text-sm text-secondary-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span id="currentDate"></span>
                </div>

                <!-- User Info Dropdown (Optional) -->
                <div class="flex items-center space-x-3 px-3 py-2 bg-secondary-50 rounded-lg">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold text-xs shadow">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-medium text-secondary-900">{{ Auth::user()->name }}</p>
                        @if(Auth::user()->roles->first())
                            <p class="text-xs text-secondary-500">{{ ucfirst(Auth::user()->roles->first()->name) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Update current date
    function updateDate() {
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const today = new Date();
        const dateElement = document.getElementById('currentDate');
        if (dateElement) {
            dateElement.textContent = today.toLocaleDateString('id-ID', options);
        }
    }
    
    document.addEventListener('DOMContentLoaded', updateDate);
</script>