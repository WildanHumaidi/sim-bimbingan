<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-lg w-full text-center">
        <h1 class="text-2xl font-bold mb-4">Selamat Datang, {{ Auth::user()->nama }}</h1>
        <p class="text-gray-600 mb-4">Anda login sebagai <strong>{{ Auth::user()->role }}</strong></p>

        @if(Auth::user()->role === 'admin')
            <div class="text-left text-sm text-gray-700 mb-4">
                <ul class="list-disc list-inside">
                    <li>Manajemen pengguna</li>
                    <li>Konfirmasi transaksi</li>
                    <li>Kelola data desa</li>
                    <!-- Tambahkan fitur lainnya sesuai kebutuhan -->
                </ul>
            </div>
        @else
            <p class="text-red-500">Anda bukan admin. Akses dibatasi.</p>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mt-6 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                Logout
            </button>
        </form>
    </div>
</body>
</html>
