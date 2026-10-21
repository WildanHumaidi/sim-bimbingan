<x-admin-layout>
    <x-slot:title>Detail User</x-slot:title>

    <div class="p-6 ml-4 mr-4">
        <div class="max-w-full bg-white rounded-lg shadow-lg">
            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Detail User: {{ $user->username }}</h1>
                        <p class="text-base text-gray-600 mt-2">Informasi lengkap tentang user ini</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.edit', $user) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="space-y-8">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informasi User
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Username</h3>
                                <p class="text-lg text-gray-900 font-semibold">{{ $user->username }}</p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email</h3>
                                <p class="text-lg text-gray-900 font-semibold">{{ $user->email }}</p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Role</h3>
                                <p class="text-lg text-gray-900 font-semibold">{{ $user->role }}</p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Status</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Dibuat</h3>
                                <p class="text-base text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Diupdate</h3>
                                <p class="text-base text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Statistik & Aktivitas
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-blue-600 uppercase tracking-wide">Bergabung Sejak</h3>
                                        <p class="text-lg font-bold text-blue-900 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="p-3 bg-blue-200 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-green-600 uppercase tracking-wide">Terakhir Update</h3>
                                        <p class="text-lg font-bold text-green-900 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="p-3 bg-green-200 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-purple-600 uppercase tracking-wide">Status</h3>
                                        <p class="text-lg font-bold text-purple-900 mt-1">Aktif</p>
                                    </div>
                                    <div class="p-3 bg-purple-200 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-200 flex flex-col sm:flex-row justify-between gap-4">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.edit', $user) }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Daftar User
                        </a>
                    </div>
                    <form action="{{ route('admin.destroy', $user) }}" method="POST"
                          class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
