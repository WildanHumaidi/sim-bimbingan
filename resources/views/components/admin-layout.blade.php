<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Load Alpine.js only once -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Other scripts -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kelompok 32</title>
    <link rel="icon" type="image/png" href="/img/kel32.png">
</head>

<body class="bg-gray-100">
    <div class="flex relative">
        {{-- Sidebar --}}
        <div id="sidebar" :class="collapsed ? 'w-20' : 'w-64'"
            class="min-h-screen bg-white border-r flex-none transition-all duration-300">
            <x-admin-sidebar />
        </div>

        {{-- Konten + Footer --}}
        <div class="flex-1 flex flex-col relative">
            {{-- Header --}}
            <x-admin-header>{{ $title }}</x-admin-header>

            {{-- Main content --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-gray-800 text-white text-sm font-semibold text-center p-2">
                <p>&copy; 2025 Kelompok 32 - All Rights Reserved</p>
            </footer>
        </div>
    </div>
</body>
</html>
