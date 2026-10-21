<header class="bg-gray-100 px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between shadow-sm">
    <!-- Kiri: Sapaan dan Judul -->
    <div class="px-0 py-0 text-gray-400">
        <div class="text-xs font-regular">Halaman</div>
        <div class="text-lg font-regular">{{ $slot }}</div>
    </div>

    <!-- Kanan: Notifikasi + Profil Dropdown -->
    <div class="flex items-center space-x-5">
        <!-- Profil Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center space-x-2 hover:text-blue-600 px-3 py-1.5 rounded-full transition">
                <img src="{{ Auth::user()->avatar_url }}"
                    alt="User Avatar"
                    class="w-8 h-8 rounded-full object-cover border border-gray-300" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-up-icon lucide-chevron-up transition-transform duration-300"
                    :class="{ '-rotate-180': open }">
                    <path d="m18 15-6-6-6 6" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50"
                x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                    </svg>
                    Profil
                </a>

                <div class="border-t my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left">
                        <div class="text-red-600 hover:bg-red-50">
                            <div class="flex items-center gap-2 px-4 py-2 text-sm">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                </svg>
                                Keluar
                            </div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
