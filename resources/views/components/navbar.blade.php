<nav x-data="{
    mobileMenuOpen: false,
    scrolled: false,
    onBeranda: window.location.pathname === '/',
}"
x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 });"
:class="(onBeranda && !scrolled) ? 'bg-transparent text-white' : 'bg-[#173C4E] shadow-lg text-gray-100'"
class="fixed top-0 w-full z-50 transition-all duration-500 ease-in-out px-6 py-4 backdrop-blur">

    <div class="flex justify-between items-center max-w-7xl mx-auto">
        <!-- Logo -->
        <a href="/">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/kel32.png') }}" alt="Logo" class="h-10">
                <span class="font-bold text-xl hidden md:inline text-white tracking-wide">KELOMPOK 32</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-8 font-semibold text-sm tracking-wide">
            <x-nav-link href="/" :active="request()->is('/')">Beranda</x-nav-link>
            <x-nav-link href="/profil-ubsi" :active="request()->is('profil-prodi')">Profil Kampus</x-nav-link>

            @php
                $bimbinganRoute = '';
                $bimbinganItems = [];
                switch(Auth::user()->role ?? 0) {
                    case 1: // Admin
                        $bimbinganRoute = 'admin/bimbingan/*';
                        $bimbinganItems = [
                            ['label' => 'Dashboard', 'href' => '/admin/dashboard'],
                            ['label' => 'Pengajuan Judul', 'href' => '/admin/bimbingan']
                        ];
                        break;
                    case 2: // Dosen
                        $bimbinganRoute = 'dosen/bimbingan/*';
                        $bimbinganItems = [
                            ['label' => 'Dashboard', 'href' => '/dosen/dashboard'],
                            ['label' => 'Pengajuan Judul', 'href' => '/dosen/bimbingan']
                        ];
                        break;
                    case 3: // Mahasiswa
                        $bimbinganRoute = 'mhs/bimbingan/*';
                        $bimbinganItems = [
                            ['label' => 'Dashboard', 'href' => '/mhs/dashboard'],
                            ['label' => 'Pengajuan Judul', 'href' => '/mhs/bimbingan']
                        ];
                        break;
                    default:
                        $bimbinganRoute = 'user/bimbingan/*';
                        $bimbinganItems = [
                            ['label' => 'Login', 'href' => '/login']
                        ];
                }
            @endphp

            <x-nav-link :dropdown="true" :active="request()->is($bimbinganRoute)" label="Bimbingan Online" :items="$bimbinganItems" />
        </div>

        <!-- Auth Button -->
        @auth
            <div x-data="{ open: false }" class="relative hidden md:block">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center space-x-2 px-3 py-2 rounded-lg text-white focus:outline-none hover:bg-white/10 transition hover:scale-105 duration-300">
                    <img src="{{ Auth::user()->avatar_url }}"
                        class="w-8 h-8 rounded-full object-cover" alt="Foto Profil">
                    <span class="font-medium">{{ Auth::user()->username }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-up transition-transform duration-300" :class="{ '-rotate-180': open }">
                        <path d="m18 15-6-6-6 6" />
                    </svg>
                </button>

                <div x-show="open" x-transition
                    class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-lg z-50 p-4">

                    <div class="flex flex-col items-center border-b border-gray-200 pb-4 mb-4">
                        <img src="{{ Auth::user()->avatar_url }}"
                            class="w-20 h-20 rounded-full object-cover mb-3" alt="Foto Profil">
                        <h3 class="text-lg font-semibold">{{ Auth::user()->username }}</h3>
                        <p class="text-sm text-gray-600 truncate max-w-full">{{ Auth::user()->email }}</p>
                    </div>

                    @php
                        $profileRoute = '';
                        switch(Auth::user()->role) {
                            case 1: $profileRoute = '/admin/profil'; break;
                            case 2: $profileRoute = '/dosen/profil'; break;
                            case 3: $profileRoute = '/mhs/profil'; break;
                            default: $profileRoute = '/profil';
                        }
                    @endphp

                    <a href="{{ $profileRoute }}"
                        class="block w-full text-center bg-[#D9A553] text-white font-semibold py-2 rounded-lg hover:bg-[#c99549] hover:scale-105 transition">
                        Edit Profil
                    </a>

                    <form method="POST" action="/logout" class="mt-3">
                        @csrf
                        <button type="submit"
                            class="w-full text-center text-red-600 border border-red-600 font-semibold py-2 rounded-lg hover:bg-red-600 hover:text-white hover:scale-105 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <form method="GET" action="/login" class="hidden md:block">
                <x-button variant="warning" size="lg"
                    class="bg-[#D9A553] hover:bg-[#c99549] text-white font-semibold px-4 py-2 shadow-lg hover:scale-105 transition">
                    Login
                </x-button>
            </form>
        @endauth

        <!-- Mobile Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden text-2xl text-white focus:outline-none hover:scale-110 transition">
            <svg x-show="!mobileMenuOpen" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="mobileMenuOpen" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden mt-4 bg-white/90 text-black font-semibold space-y-4 py-4 px-4 rounded-lg shadow-lg">
        <a href="/" class="block hover:text-[#D9A553] transition">Beranda</a>
        <a href="/profil-prodi" class="block hover:text-[#D9A553] transition">Profil Prodi</a>
        <a href="/informasi/berita" class="block hover:text-[#D9A553] transition">Berita Kampus</a>
        <a href="{{ route('peraturan') }}" class="block hover:text-[#D9A553] transition">Peraturan Skripsi</a>

        @auth
            @php
                $mobileProfileRoute = '';
                $mobileBimbinganRoute = '';
                $mobileDashboardRoute = '';
                switch(Auth::user()->role) {
                    case 1:
                        $mobileProfileRoute = '/admin/profil';
                        $mobileBimbinganRoute = '/admin/bimbingan';
                        $mobileDashboardRoute = '/admin/dashboard';
                        break;
                    case 2:
                        $mobileProfileRoute = '/dosen/profil';
                        $mobileBimbinganRoute = '/dosen/bimbingan';
                        $mobileDashboardRoute = '/dosen/dashboard';
                        break;
                    case 3:
                        $mobileProfileRoute = '/mhs/profil';
                        $mobileBimbinganRoute = '/mhs/bimbingan';
                        $mobileDashboardRoute = '/mhs/dashboard';
                        break;
                    default:
                        $mobileProfileRoute = '/profil';
                        $mobileBimbinganRoute = '/login';
                        $mobileDashboardRoute = '/login';
                }
            @endphp

            <a href="{{ $mobileDashboardRoute }}" class="block hover:text-[#D9A553] transition">Dashboard</a>
            <a href="{{ $mobileBimbinganRoute }}" class="block hover:text-[#D9A553] transition">Pengajuan Judul</a>
            <a href="{{ $mobileProfileRoute }}" class="block hover:text-[#D9A553] transition">Edit Profil</a>

            <form method="POST" action="/logout">
                @csrf
                <button class="block w-full bg-red-500 text-white py-2 rounded-lg hover:scale-105 transition">Logout</button>
            </form>
        @else
            <a href="/login"
                class="block bg-[#D9A553] hover:bg-[#c99549] text-white text-center py-2 rounded-lg hover:scale-105 transition">Login</a>
        @endauth
    </div>
</nav>
