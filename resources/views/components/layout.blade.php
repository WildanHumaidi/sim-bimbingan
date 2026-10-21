<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Figtree&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kelompok 32</title>
    <link rel="icon" type="image/png" href="/img/kel32.png">
</head>

<body>
    {{-- untuk cloack herro section wellcome --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    <div class="bg-white">
        <x-navbar></x-navbar>
        <main>
            <div> {{ $slot }}
            </div>
        </main>
        <x-footer></x-footer>
    </div>

</body>

</html>
