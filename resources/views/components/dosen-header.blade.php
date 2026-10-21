@props(['bimbinganBaru' => collect([])])

<header class="bg-white px-4 py-2 flex items-center justify-end shadow-sm fixed top-0 right-0 z-20 transition-all duration-300"
        :class="collapsed ? 'left-20' : 'left-64'">

    <!-- Notification Bell -->
    <div class="relative mr-4" x-data="{
        showNotifications: false,
        newBimbinganCount: {{ $bimbinganBaru->count() }},
        notifications: {{ json_encode($bimbinganBaru->map(function($item) {
            return [
                'id' => $item->id_bimbingan,
                'mahasiswa_nama' => $item->mahasiswa->nama,
                'tanggal' => $item->tanggal->format('d M Y, H:i'),
                'created_at' => $item->tanggal->diffForHumans(),
                'is_read' => !is_null($item->dibaca_oleh_dosen)
            ];
        })) }},
        isLoading: false,
        showToast: false,
        toastMessage: '',
        toastType: 'success',

        async showToastMessage(message, type = 'success') {
            this.toastMessage = message;
            this.toastType = type;
            this.showToast = true;
            setTimeout(() => { this.showToast = false; }, 3500);
        },

        async checkNewBimbingan() {
            if (this.isLoading) return;

            try {
                const response = await fetch('/dosen/dashboard/check-new-bimbingan');
                if (!response.ok) throw new Error('Network error');

                const data = await response.json();
                if (data.count > this.newBimbinganCount) {
                    this.showToastMessage('Ada bimbingan baru!', 'info');
                }
                this.newBimbinganCount = data.count;
                this.notifications = data.data;
            } catch (error) {
                console.error('Error checking new bimbingan:', error);
            }
        },

        async markAsRead(id) {
            if (this.isLoading) return;
            this.isLoading = true;

            try {
                const response = await fetch(`/dosen/dashboard/tandai-dibaca/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    }
                });

                const result = await response.json();
                if (result.success) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                    this.newBimbinganCount = Math.max(0, this.newBimbinganCount - 1);
                    this.showToastMessage(result.message, 'success');

                    if (this.notifications.length === 0) {
                        this.showNotifications = false;
                    }
                } else {
                    this.showToastMessage(result.message || 'Gagal menandai sebagai dibaca', 'error');
                }
            } catch (error) {
                this.showToastMessage('Terjadi kesalahan', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        async markAllAsRead() {
            if (this.isLoading || this.newBimbinganCount === 0) return;
            this.isLoading = true;

            try {
                const response = await fetch('/dosen/dashboard/tandai-semua-dibaca', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    }
                });

                const result = await response.json();
                if (result.success) {
                    this.notifications = [];
                    this.newBimbinganCount = 0;
                    this.showNotifications = false;
                    this.showToastMessage(result.message, 'success');
                } else {
                    this.showToastMessage(result.message || 'Gagal menandai semua', 'error');
                }
            } catch (error) {
                this.showToastMessage('Terjadi kesalahan', 'error');
            } finally {
                this.isLoading = false;
            }
        }
    }"
    x-init="setInterval(() => checkNewBimbingan(), 30000)"
    @click.outside="showNotifications = false">

    {{-- Notification Bell Button --}}
    <button @click="showNotifications = !showNotifications"
            class="relative p-2.5 rounded-full hover:bg-gray-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 group"
            :class="{ 'animate-pulse': isLoading }"
            aria-label="Notifikasi"
            x-tooltip="Notifikasi">

        {{-- Bell Icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="text-gray-600 group-hover:text-blue-600 transition-transform group-hover:scale-110 duration-150">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
        </svg>

        {{-- NOTIFICATION BADGE --}}
        <span x-show="newBimbinganCount > 0"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 scale-75 -translate-y-1"
              x-transition:enter-end="opacity-100 scale-100 translate-y-0"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 scale-100 translate-y-0"
              x-transition:leave-end="opacity-0 scale-75 translate-y-1"
              class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-semibold rounded-full h-[22px] min-w-[22px] px-[6px] flex items-center justify-center shadow-md leading-none transform transition-all duration-300 hover:scale-110 hover:bg-red-600"
              :class="{
                'animate-bounce': newBimbinganCount > 0 && !showNotifications
              }"
              x-text="newBimbinganCount > 99 ? '99+' : newBimbinganCount"
              style="animation-duration: 2s; animation-iteration-count: 2;">
        </span>

        {{-- Ripple --}}
        <span class="absolute inset-0 rounded-full bg-blue-100 opacity-0 group-active:opacity-30 transition-opacity duration-300"></span>
    </button>

    {{-- Dropdown --}}
    <div x-show="showNotifications"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
         class="absolute top-12 right-0 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 max-h-[36rem] overflow-hidden z-50 backdrop-blur-sm"
         style="box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">

        {{-- Header --}}
        <div class="p-5 border-b border-gray-200 bg-blue-50">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                    <h3 class="font-semibold text-gray-800 text-lg">Notifikasi Bimbingan</h3>
                </div>
                <button @click="showNotifications = false"
                        class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-white/50 transition-all duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span x-show="newBimbinganCount > 0"
                      class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium"
                      x-text="newBimbinganCount + ' baru'"></span>
                <span x-show="newBimbinganCount === 0"
                      class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
                    Semua sudah dibaca</span>
                <button x-show="newBimbinganCount > 0"
                        @click="markAllAsRead()"
                        :disabled="isLoading"
                        class="text-sm text-blue-600 hover:text-blue-800 disabled:opacity-50 font-medium px-4 py-2 rounded-full hover:bg-blue-50 transition-all duration-200">
                    <span x-show="!isLoading">Tandai Semua Dibaca</span>
                    <span x-show="isLoading" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </div>

        {{-- List --}}
        <div class="max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <template x-if="notifications.length === 0">
                <div class="p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 21H6a2 2 0 01-2-2V5a2 2 0 012-2h6m0 18v-8a2 2 0 012-2h8z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-base font-medium">Tidak ada notifikasi baru</p>
                    <p class="text-gray-400 text-sm mt-2">Semua bimbingan sudah ditandai sebagai dibaca</p>
                </div>
            </template>

            <template x-for="notification in notifications" :key="notification.id">
                <div class="p-5 border-b border-gray-100 hover:bg-blue-50 transition-all duration-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 mr-4">
                            <div class="flex items-center mb-3">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-4"></div>
                                <h4 class="font-semibold text-gray-800 text-base" x-text="notification.mahasiswa_nama"></h4>
                            </div>
                            <div class="ml-7">
                                <p class="text-base text-gray-600 mb-2 font-medium">Bimbingan baru telah dibuat</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span x-text="notification.created_at"></span>
                                </div>
                            </div>
                        </div>
                        <button @click="markAsRead(notification.id)"
                                :disabled="isLoading"
                                class="ml-3 text-sm bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 disabled:opacity-50 font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                            <span x-show="!isLoading">Tandai Dibaca</span>
                            <span x-show="isLoading" class="flex items-center">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<!-- Toast Notification (Centered in Header) -->
<div x-show="showToast"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
     x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-[60] pointer-events-none">
    <div class="rounded-xl shadow-2xl p-4 text-white text-sm font-medium max-w-sm mx-auto backdrop-blur-sm"
         :class="{
            'bg-green-500': toastType === 'success',
            'bg-blue-500': toastType === 'info',
            'bg-yellow-500': toastType === 'warning',
            'bg-red-500': toastType === 'error'
         }"
         style="box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div class="flex items-center justify-center">
            <div class="mr-3 p-1 bg-white/20 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="toastType === 'success'" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    <path x-show="toastType === 'info'" fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    <path x-show="toastType === 'warning'" fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    <path x-show="toastType === 'error'" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <span x-text="toastMessage" class="text-center font-semibold"></span>
        </div>
    </div>
</div>

<!-- Profil Dropdown -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
        class="flex items-center space-x-2 hover:text-blue-600 px-3 py-2 rounded-xl transition-all duration-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        <div class="text-right mr-2 hidden md:block">
            <div class="text-sm font-semibold text-gray-800 truncate max-w-[120px]">{{ Auth::user()->dosen?->nama ?? Auth::user()->username }}</div>
            <div class="text-xs text-gray-500 capitalize">Dosen</div>
        </div>
        <div class="relative">
            <img src="{{ Auth::user()->avatar_url }}"
                alt="User Avatar"
                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 shadow-md">
            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-chevron-down transition-transform duration-200"
            :class="{ 'rotate-180': open }">
            <path d="m6 9 6 6 6-6"/>
        </svg>
    </button>

    <div x-show="open" @click.away="open = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-40 backdrop-blur-sm"
        style="box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div class="px-4 py-3 border-b border-gray-100">
            <div class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
        </div>
        <a href="{{ route('dosen.profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-all duration-200">
            <div class="p-1 bg-blue-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user text-blue-600">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span class="font-medium">Profil Saya</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                <div class="p-1 bg-red-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out text-red-600">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" x2="9" y1="12" y2="12"/>
                    </svg>
                </div>
                <span class="font-medium">Keluar</span>
            </button>
        </form>
    </div>
</div>
</header>

<div class="fixed top-4 left-0 z-10 transition-all duration-300 ml-4"
     :class="collapsed ? 'ml-24' : 'ml-72'">
    <div class="text-gray-400">
        <div class="text-xs font-medium uppercase tracking-wide">Halaman</div>
        <div class="text-lg font-semibold text-gray-800 mt-1">{{ $slot }}</div>
    </div>
</div>
