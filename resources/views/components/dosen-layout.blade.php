<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    {{-- script untuk chart keuangan di dashboard admin --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <title>Kelompok 32</title>
    <link rel="icon" type="image/png" href="/img/kel32.png">
</head>

<body class="bg-gray-50" x-data="{ collapsed: false }">
    <!-- Sidebar -->
    <div class="fixed h-full z-30">
        <x-dosen-sidebar />
    </div>

    <!-- Header -->
    <x-dosen-header>{{ $title }}</x-dosen-header>

    <!-- Main Content -->
    <main class="transition-all duration-300 min-h-screen pt-20 pb-6"
          :class="collapsed ? 'ml-20 pl-4' : 'ml-64 pl-6'">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t py-3 text-center text-sm text-gray-500">
        &copy; 2025 Kelompok 32 - All Rights Reserved
    </footer>
</body>
</html>
