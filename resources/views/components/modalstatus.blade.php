<div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }" x-init="setTimeout(() => {
    showSuccess = false;
    showError = false
}, 10000)" class="fixed top-5 right-5 z-50 space-y-2 w-96">

    <!-- Notifikasi sukses -->
    <div x-show="showSuccess" x-transition
        class="flex justify-between items-center px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm">{{ session('success') }}</span>
        </div>
        <button @click="showSuccess = false" class="hover:scale-125 transition text-green-800 hover:text-green-900 text-xl leading-none">
            &times;
        </button>
    </div>

    <!-- Notifikasi gagal -->
    <div x-show="showError" x-transition
        class="flex justify-between items-center px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow">
        <div class="flex items-center gap-2">
            <!-- Ganti ikon dari × ke ikon alert seperti exclamation -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01M12 5a7 7 0 1 1 0 14a7 7 0 0 1 0-14z" />
            </svg>
            <span class="text-sm">{{ session('error') }}</span>
        </div>
        <!-- Tombol tutup tetap pakai × -->
        <button @click="showError = false" class="hover:scale-125 transition ml-2 text-red-800 hover:text-red-900 text-xl leading-none">
            &times;
        </button>
    </div>


</div>
