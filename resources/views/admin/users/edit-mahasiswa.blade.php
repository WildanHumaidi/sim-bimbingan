<x-admin-layout>
    <x-slot:title>Edit Mahasiswa</x-slot:title>

    <div class="p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Edit Mahasiswa</h1>
                        <p class="text-md text-gray-600 mt-2">Update data mahasiswa</p>
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
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.update.mahasiswa', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Role Badge -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Mahasiswa
                        </span>
                    </div>

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" id="username" name="username"
                                value="{{ old('username', $user->username) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $user->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>
                    </div>

                    <!-- Mahasiswa Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="id_nim" class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                            <input type="text" id="id_nim" name="id_nim"
                                value="{{ old('id_nim', $user->mahasiswa->id_nim) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="nama_mahasiswa" name="nama_mahasiswa"
                                value="{{ old('nama_mahasiswa', $user->mahasiswa->nama) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label for="program_studi" class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                            <input type="text" id="program_studi" name="program_studi"
                                value="{{ old('program_studi', $user->mahasiswa->program_studi) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-2">Angkatan</label>
                            <input type="number" id="angkatan" name="angkatan"
                                value="{{ old('angkatan', $user->mahasiswa->angkatan) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                min="2000" max="{{ date('Y') + 1 }}" required>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Ubah Password</h3>
                        <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Mahasiswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
