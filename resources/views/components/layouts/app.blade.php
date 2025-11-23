{{-- resources/views/components/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="h-full bg-secondary-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - EMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/sidebar.js'])
    @livewireStyles
</head>
<body class="h-full overflow-hidden">
    
    <!-- Top Loading Bar -->
    <div id="topLoadingBar" class="top-loading-bar"></div>

    <div class="flex h-screen bg-secondary-50">
        <!-- Sidebar Component -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar Component -->
            <x-navbar :title="$title ?? 'Dashboard'" />

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-secondary-50 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>