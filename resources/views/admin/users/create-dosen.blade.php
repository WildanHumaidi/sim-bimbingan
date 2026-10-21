<x-admin-layout>
    <x-slot:title>Tambah Dosen Baru</x-slot:title>

    <div class="p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-8 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Tambah Dosen Baru</h1>
                        <p class="text-md text-gray-600 mt-2">Lengkapi form di bawah untuk menambahkan dosen baru</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                        </div>
                        <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.store.dosen') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- User Information -->
                        <div class="space-y-6">
                            <div class="pb-4 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Informasi User
                                </h2>
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-md font-medium text-gray-700 mb-3">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('username') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="username" name="username" value="{{ old('username') }}" required
                                    placeholder="Masukkan username">
                                @error('username')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-md font-medium text-gray-700 mb-3">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="contoh@email.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-md font-medium text-gray-700 mb-3">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="password" name="password" required
                                    placeholder="Masukkan password (minimal 8 karakter)">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-md font-medium text-gray-700 mb-3">
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    id="password_confirmation" name="password_confirmation" required
                                    placeholder="Ulangi password">
                            </div>
                        </div>

                        <!-- Dosen Information -->
                        <div class="space-y-6">
                            <div class="pb-4 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    Informasi Dosen
                                </h2>
                            </div>

                            <!-- NIDN -->
                            <div>
                                <label for="id_nidn" class="block text-md font-medium text-gray-700 mb-3">
                                    NIDN <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('id_nidn') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="id_nidn" name="id_nidn" value="{{ old('id_nidn') }}" required
                                    placeholder="Contoh: 0123456789">
                                @error('id_nidn')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Nomor Induk Dosen Nasional</p>
                            </div>

                            <!-- Nama Dosen -->
                            <div>
                                <label for="nama_dosen" class="block text-md font-medium text-gray-700 mb-3">
                                    Nama Dosen <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nama_dosen') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen') }}" required
                                    placeholder="Nama lengkap dosen">
                                @error('nama_dosen')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div>
                                <label for="jabatan" class="block text-md font-medium text-gray-700 mb-3">
                                    Jabatan <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('jabatan') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="jabatan" name="jabatan" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="Asisten Ahli" {{ old('jabatan') == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                                    <option value="Lektor" {{ old('jabatan') == 'Lektor' ? 'selected' : '' }}>Lektor</option>
                                    <option value="Lektor Kepala" {{ old('jabatan') == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                                    <option value="Guru Besar" {{ old('jabatan') == 'Guru Besar' ? 'selected' : '' }}>Guru Besar</option>
                                </select>
                                @error('jabatan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fakultas -->
                            <div>
                                <label for="fakultas" class="block text-md font-medium text-gray-700 mb-3">
                                    Fakultas <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('fakultas') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="fakultas" name="fakultas" required>
                                    <option value="">-- Pilih Fakultas --</option>
                                    @foreach($fakultas_list as $fakultas)
                                        <option value="{{ $fakultas }}" {{ old('fakultas') == $fakultas ? 'selected' : '' }}>{{ $fakultas }}</option>
                                    @endforeach
                                </select>
                                @error('fakultas')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4 pt-8 border-t border-gray-200">
                        <a href="{{ route('admin.users.create') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors text-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Dosen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
