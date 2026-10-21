<!-- Tambahan Sidebar -->
<div x-data="{ open: {{ request()->routeIs('profile.*') || request()->routeIs('user.*') ? 'true' : 'false' }} }" :class="collapsed ? 'w-20' : 'w-64'"
    class="bg-white border-r transition-all duration-300 flex flex-col fixed h-full z-20">
    <!-- Logo & Collapse Button -->
    <div class="flex items-center justify-between px-4 py-4 border-b">
        <div x-show="!collapsed" class="transition-opacity duration-200">
            <img src="{{ asset('img/kel32.png') }}" alt="Logo" class="h-10 w-auto">
        </div>

        <!-- Tombol Toggle Collapse -->
        <button @click="collapsed = !collapsed"
            class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 flex-shrink-0"
            :class="collapsed ? 'mx-auto' : ''">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                :class="collapsed ? 'rotate-180' : ''" class="transition-transform duration-300">
                <path d="M11 17l-5-5 5-5" />
                <path d="M18 17l-5-5 5-5" />
            </svg>
        </button>
    </div>


    <!-- Menu -->
    <nav class="flex-1 px-3 py-4 space-y-2 text-gray-800 text-sm font-medium overflow-y-auto">
        <!-- Menu Dashboard -->
        <a href="{{ route('dosen.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('dosen.dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}"
            :class="collapsed ? 'justify-center' : ''" :title="collapsed ? 'Dashboard' : ''">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-layout-dashboard flex-shrink-0">
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="12" rx="1" />
                <rect width="7" height="9" x="3" y="12" rx="1" />
            </svg>
            <span x-show="!collapsed" class="transition-opacity duration-200">Dashboard</span>
        </a>

        <!-- Kelola Akun -->
        <div x-data="{ open: {{ request()->routeIs('profile.*') || request()->routeIs('user.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 hover:bg-gray-100 rounded-lg transition-all"
                :class="collapsed ? 'justify-center' : ''" :title="collapsed ? 'Kelola Akun' : ''">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-user-round-cog-icon lucide-user-round-cog flex-shrink-0">
                        <path d="m14.305 19.53.923-.382" />
                        <path d="m15.228 16.852-.923-.383" />
                        <path d="m16.852 15.228-.383-.923" />
                        <path d="m16.852 20.772-.383.924" />
                        <path d="m19.148 15.228.383-.923" />
                        <path d="m19.53 21.696-.382-.924" />
                        <path d="M2 21a8 8 0 0 1 10.434-7.62" />
                        <path d="m20.772 16.852.924-.383" />
                        <path d="m20.772 19.148.924.383" />
                        <circle cx="10" cy="8" r="5" />
                        <circle cx="18" cy="18" r="3" />
                    </svg>
                    <span x-show="!collapsed" class="transition-opacity duration-200">Kelola Akun</span>
                </div>
                <svg x-show="!collapsed" :class="open ? 'rotate-90' : ''"
                    class="w-4 h-4 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>


            <!-- Submenu hanya muncul jika tidak collapsed -->
            <div x-show="open && !collapsed" x-collapse x-cloak class="space-y-1 pl-10 mt-1">
                <a href="{{ route('dosen.profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 text-xs rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('profile.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-user-round-cog-icon lucide-user-round-cog">
                        <path d="m14.305 19.53.923-.382" />
                        <path d="m15.228 16.852-.923-.383" />
                        <path d="m16.852 15.228-.383-.923" />
                        <path d="m16.852 20.772-.383.924" />
                        <path d="m19.148 15.228.383-.923" />
                        <path d="m19.53 21.696-.382-.924" />
                        <path d="M2 21a8 8 0 0 1 10.434-7.62" />
                        <path d="m20.772 16.852.924-.383" />
                        <path d="m20.772 19.148.924.383" />
                        <circle cx="10" cy="8" r="5" />
                        <circle cx="18" cy="18" r="3" />
                    </svg>
                    <span>Profil</span>
                </a>
            </div>
        </div>

        <!-- Menu Bimbingan -->
        <a href="{{ route('dosen.bimbingan.index') }}"
            class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('dosen.bimbingan.*') ? 'text-blue-600 font-semibold' : 'text-gray-800' }}"
            :class="collapsed ? 'justify-center' : ''" :title="collapsed ? 'Bimbingan' : ''">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-file-text flex-shrink-0">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" x2="8" y1="13" y2="13" />
                <line x1="16" x2="8" y1="17" y2="17" />
                <line x1="10" x2="8" y1="9" y2="9" />
            </svg>
            <span x-show="!collapsed" class="transition-opacity duration-200">Bimbingan</span>
        </a>
    </nav>

    <!-- Logout Button -->
    <div class="px-3 py-4 border-t">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 px-3 py-2 w-full rounded-lg hover:text-red-600 hover:bg-gray-100 transition-all text-gray-800 text-sm font-medium"
                :class="collapsed ? 'justify-center' : ''" :title="collapsed ? 'Logout' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out flex-shrink-0">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
                <span x-show="!collapsed" class="transition-opacity duration-200">Logout</span>
            </button>
        </form>
    </div>
</div>
