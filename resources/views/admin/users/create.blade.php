<x-admin-layout>
    <x-slot:title>Pilih Jenis User Baru</x-slot:title>

    <div class="p-6">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Tambah User Baru</h1>
                        <p class="text-md text-gray-600 mt-2">Pilih jenis user yang ingin ditambahkan</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Admin Card -->
                    <a href="{{ route('admin.users.create.admin') }}" class="group">
                        <div class="p-6 border border-gray-200 rounded-lg hover:border-blue-500 transition-colors h-full flex flex-col">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-3 bg-blue-100 rounded-full">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600">Admin</h3>
                            </div>
                            <p class="text-gray-600 flex-grow">User dengan akses penuh ke seluruh sistem</p>
                            <div class="mt-4 text-blue-600 flex items-center gap-1">
                                <span>Pilih</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    <!-- Dosen Card -->
                    <a href="{{ route('admin.users.create.dosen') }}" class="group">
                        <div class="p-6 border border-gray-200 rounded-lg hover:border-green-500 transition-colors h-full flex flex-col">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-3 bg-green-100 rounded-full">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-green-600">Dosen</h3>
                            </div>
                            <p class="text-gray-600 flex-grow">Tenaga pengajar dengan akses terbatas</p>
                            <div class="mt-4 text-green-600 flex items-center gap-1">
                                <span>Pilih</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    <!-- Mahasiswa Card -->
                    <a href="{{ route('admin.users.create.mahasiswa') }}" class="group">
                        <div class="p-6 border border-gray-200 rounded-lg hover:border-purple-500 transition-colors h-full flex flex-col">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-3 bg-purple-100 rounded-full">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-purple-600">Mahasiswa</h3>
                            </div>
                            <p class="text-gray-600 flex-grow">User dengan akses terbatas sebagai mahasiswa</p>
                            <div class="mt-4 text-purple-600 flex items-center gap-1">
                                <span>Pilih</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
