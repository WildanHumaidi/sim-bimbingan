<x-mhs-layout>
    <x-slot:title>Edit Profil</x-slot>

    <div class="max-w-5xl mx-auto mt-8 p-8 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl">
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Profil</h2>

        <form action="{{ route('mhs.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="grid md:grid-cols-3 gap-10">
                <!-- Form Fields -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Username -->
                    <div class="space-y-3">
                        <label for="username" class="block text-sm font-semibold text-gray-700">Username</label>
                        <input type="text" id="username" name="username"
                            value="{{ old('username', $user->username) }}"
                            class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" required />
                        @error('username')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="space-y-3">
                        <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama"
                            value="{{ old('nama', $user->mahasiswa ? $user->mahasiswa->nama : $user->username) }}"
                            class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" required />
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIM -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">NIM</label>
                        <input type="text" value="{{ $user->mahasiswa->id_nim ?? '' }}" readonly
                            class="w-full px-4 py-2 border rounded-xl bg-gray-100 cursor-not-allowed" />
                    </div>

                    <!-- Program Studi -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">Program Studi</label>
                        <input type="text" value="{{ $user->mahasiswa->program_studi ?? '' }}" readonly
                            class="w-full px-4 py-2 border rounded-xl bg-gray-100 cursor-not-allowed" />
                    </div>

                    <!-- Angkatan -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">Angkatan</label>
                        <input type="text" value="{{ $user->mahasiswa->angkatan ?? '' }}" readonly
                            class="w-full px-4 py-2 border rounded-xl bg-gray-100 cursor-not-allowed" />
                    </div>

                    <!-- Email -->
                    <div class="space-y-3">
                        <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" required />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-3">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password (kosongkan jika
                            tidak diubah)</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Foto dan Status -->
                <div class="space-y-6 flex flex-col items-center">
                    <div class="relative w-36 h-36">
                        <img src="{{ $user->foto ? asset('profile/mhs/' . $user->foto) : '/images/profil-default.jpg' }}"
                        class="w-full h-full rounded-full object-cover border-4 border-white shadow-xl transition-all duration-300"
                        alt="Foto Profil" id="previewFoto">

                        <!-- Overlay Ganti Foto -->
                        <input type="file" class="hidden" id="foto" name="foto"
                            accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this)">
                        <label for="foto"
                            class="absolute inset-0 flex items-center justify-center bg-black/50 text-white text-sm font-medium rounded-full opacity-0 hover:opacity-100 transition cursor-pointer">
                            Ganti Foto
                        </label>

                        <!-- Badge Verifikasi -->
                        <div
                            class="flex items-center space-x-1 bg-white rounded-full px-2 py-0.5 mt-4 shadow border border-gray-300">
                            <svg class="{{ $user->status_verifikasi ? 'text-blue-600' : 'text-gray-400' }} w-[20px] h-[20px]"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span
                                class="text-xs font-semibold {{ $user->status_verifikasi ? 'text-blue-600' : 'text-gray-400' }}">
                                {{ $user->status_verifikasi ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end mt-10 gap-4">
                <a href="{{ route('mhs.profile.edit') }}"
                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold">Batal</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-all">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('previewFoto');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-mhs-layout>
