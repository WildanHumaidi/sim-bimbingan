<x-admin-layout>
    <x-slot:title>Edit Dosen</x-slot:title>

    <div class="p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Edit Dosen</h1>
                        <p class="text-md text-gray-600 mt-2">Update data dosen</p>
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

                <form action="{{ route('admin.update.dosen', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Role Badge -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Dosen
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

                    <!-- Dosen Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="id_nidn" class="block text-sm font-medium text-gray-700 mb-2">NIDN</label>
                            <input type="text" id="id_nidn" name="id_nidn"
                                value="{{ old('id_nidn', $user->dosen->id_nidn) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label for="nama_dosen" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="nama_dosen" name="nama_dosen"
                                value="{{ old('nama_dosen', $user->dosen->nama) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan"
                                value="{{ old('jabatan', $user->dosen->jabatan) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                            <select id="fakultas" name="fakultas"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                                @foreach($fakultas_list as $fakultas)
                                    <option value="{{ $fakultas }}" {{ old('fakultas', $user->dosen->fakultas) == $fakultas ? 'selected' : '' }}>
                                        {{ $fakultas }}
                                    </option>
                                @endforeach
                            </select>
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
                            Update Dosen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
