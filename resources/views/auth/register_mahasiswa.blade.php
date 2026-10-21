<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mahasiswa</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/img/kel32.png">
</head>

<body class="h-full flex items-center justify-center">

    <!-- DESKTOP -->
    <div x-data="{
        nim: '',
        nama: '',
        program_studi: '',
        angkatan: '',
        email: '',
        password: '',
        password_confirmation: '',
        showPassword: false,
        showPasswordConfirmation: false,
        agree: false,
    }" class="hidden md:flex w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden relative">

        <!-- Left Panel -->
        <div class="flex w-full md:w-1/2 p-8 relative z-10 flex-col justify-center">
            @if ($errors->any())
                <div x-data="{ showError: true }" x-show="showError" x-transition
                    class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm flex justify-between items-center">
                    <div>
                        <strong>Registrasi gagal:</strong>
                        <ul class="list-disc pl-5 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="showError = false" class="text-red-500 hover:text-red-800">&times;</button>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form @submit.prevent="if (!agree) { alert('Setujui Terms & Conditions!'); return; } $el.submit();" method="POST"
                action="{{ route('register.mahasiswa') }}" class="bg-white p-8 rounded shadow-md w-full max-w-md space-y-4">
                @csrf
                <h2 class="text-3xl font-bold text-blue-700 text-center">Registrasi Mahasiswa</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="nim" x-model="nim" placeholder="NIM" required
                        value="{{ old('nim') }}" maxlength="10"
                        class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <input type="number" name="angkatan" x-model="angkatan" placeholder="Angkatan" required
                        value="{{ old('angkatan') }}"
                        class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <input type="text" name="nama" x-model="nama" placeholder="Nama Lengkap" required
                    value="{{ old('nama') }}"
                    class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <input type="text" name="program_studi" x-model="program_studi" placeholder="Program Studi" required
                    value="{{ old('program_studi') }}"
                    class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <input type="email" name="email" x-model="email" placeholder="Email" required
                    value="{{ old('email') }}"
                    class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" x-model="password" name="password"
                        placeholder="Password" required
                        class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <span x-text="showPassword ? '👁️' : '👁️‍🗨️'"></span>
                    </button>
                </div>

                <div class="relative">
                    <input :type="showPasswordConfirmation ? 'text' : 'password'" x-model="password_confirmation" name="password_confirmation"
                        placeholder="Konfirmasi Password" required
                        class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <span x-text="showPasswordConfirmation ? '👁️' : '👁️‍🗨️'"></span>
                    </button>
                </div>

                <div class="flex items-center space-x-2">
                    <input x-model="agree" type="checkbox" required
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label class="text-gray-600 text-sm">
                        Saya setuju dengan <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-700 text-white py-3 rounded hover:bg-blue-800 transition font-bold">
                    Daftar Mahasiswa
                </button>

                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-2 text-gray-400 text-sm">ATAU</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <a href="{{ url('/auth/google') }}"
                    class="w-full border border-gray-300 py-3 rounded flex items-center justify-center hover:bg-gray-100 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-2">
                    <span class="text-gray-700 font-semibold">Daftar dengan Google</span>
                </a>

                <div class="text-center mt-4">
                    <p class="text-gray-600">Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login disini</a>
                    </p>
                    <p class="text-gray-600 text-sm mt-2">Atau daftar sebagai
                        <a href="{{ route('register.dosen') }}" class="text-blue-600 hover:underline">Dosen</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Right Panel -->
        <div class="hidden md:flex w-1/2 bg-gradient-to-r from-blue-700 to-blue-900 text-white items-center justify-center p-8">
            <div class="text-center space-y-6">
                <img src="{{ asset('img/kel32.png') }}" alt="Logo" class="h-12 mx-auto">
                <h2 class="text-3xl font-bold">Bergabung dengan Sistem Bimbingan Tugas Akhir</h2>
                <p class="text-sm">Sudah punya akun? Silakan login untuk melanjutkan.</p>
                <div class="space-y-3">
                    <a href="{{ route('login') }}"
                        class="block bg-white text-blue-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">Login</a>
                    <a href="{{ route('register.dosen') }}"
                        class="block border-2 border-white text-white px-6 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-700 transition">Daftar sebagai Dosen</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MOBILE -->
    <div class="flex md:hidden w-full min-h-screen items-center justify-center p-4">
        <div x-data="{
            nim: '',
            nama: '',
            program_studi: '',
            angkatan: '',
            email: '',
            password: '',
            password_confirmation: '',
            showPassword: false,
            showPasswordConfirmation: false,
            agree: false,
        }" class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 space-y-4">
            <div class="text-center">
                <img src="{{ asset('img/kel32.png') }}" alt="Logo" class="h-10 mx-auto mb-2">
                <h2 class="text-xl font-bold text-blue-700">Registrasi Mahasiswa</h2>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded text-sm">
                    <strong>Registrasi gagal:</strong>
                    <ul class="list-disc pl-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form @submit.prevent="if (!agree) { alert('Setujui Terms & Conditions!'); return; } $el.submit();" method="POST" action="{{ route('register.mahasiswa') }}" class="space-y-3">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="nim" x-model="nim" placeholder="NIM" value="{{ old('nim') }}" maxlength="10" required
                        class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <input type="number" name="angkatan" x-model="angkatan" placeholder="Angkatan" value="{{ old('angkatan') }}" required
                        class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <input type="text" name="nama" x-model="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required
                    class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                <input type="text" name="program_studi" x-model="program_studi" placeholder="Program Studi" value="{{ old('program_studi') }}" required
                    class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                <input type="email" name="email" x-model="email" placeholder="Email" value="{{ old('email') }}" required
                    class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" x-model="password" name="password" placeholder="Password" required
                        class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <span x-text="showPassword ? '👁️' : '👁️‍🗨️'"></span>
                    </button>
                </div>

                <div class="relative">
                    <input :type="showPasswordConfirmation ? 'text' : 'password'" x-model="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required
                        class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <span x-text="showPasswordConfirmation ? '👁️' : '👁️‍🗨️'"></span>
                    </button>
                </div>

                <div class="flex items-center space-x-2">
                    <input x-model="agree" type="checkbox" required
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label class="text-gray-600 text-sm">Saya setuju dengan
                        <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-700 text-white py-3 rounded hover:bg-blue-800 transition font-bold">Daftar Mahasiswa</button>

                <div class="text-center text-sm text-gray-600 space-y-1">
                    <div>
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login disini</a>
                    </div>
                    <div>
                        Atau daftar sebagai
                        <a href="{{ route('register.dosen') }}" class="text-blue-600 hover:underline">Dosen</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
