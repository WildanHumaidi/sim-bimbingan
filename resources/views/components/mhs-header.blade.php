<header class="bg-white px-6 py-4 flex items-center justify-end shadow-sm fixed top-0 right-0 z-20 transition-all duration-300"
        :class="collapsed ? 'left-20' : 'left-64'">
    <!-- Profil Dropdown (Posisi Kanan) -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
            class="flex items-center space-x-2 hover:text-blue-600 px-3 py-1.5 rounded-full transition">
            <div class="text-right mr-2 hidden md:block">
                <div class="text-sm font-medium text-gray-800">{{ Auth::user()->mahasiswa?->nama ?? Auth::user()->username }}</div>
                <div class="text-xs text-gray-500">Mahasiswa</div>
            </div>
            <img src="{{ Auth::user()->avatar_url }}"
                alt="User Avatar"
                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-chevron-down transition-transform duration-200 ml-1"
                :class="{ 'rotate-180': open }">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" @click.away="open = false"
            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-50"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">

            <!-- Info Profil -->
            <div class="px-4 py-3 border-b">
                <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
            </div>

            <!-- Menu Profil -->
            <a href="{{ route('mhs.profile.edit') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-user">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Profil Saya
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-log-out">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" x2="9" y1="12" y2="12"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>

<div class="fixed top-4 left-0 z-10 transition-all duration-300 ml-4"
     :class="collapsed ? 'ml-24' : 'ml-72'">
    <div class="text-gray-400">
        <div class="text-xs font-regular">Halaman</div>
        <div class="text-lg font-medium text-gray-800">{{ $slot }}</div>
    </div>
</div>
