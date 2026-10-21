<x-admin-layout>
    <x-slot:title>Edit Profil</x-slot>

    <div class="max-w-5xl mx-auto mt-8 p-8 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl" x-data="editProfile"
        x-init="init()" x-cloak>
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Profil</h2>

        <div class="grid md:grid-cols-3 gap-10">
            <!-- Form Fields -->
            <div class="md:col-span-2 space-y-6">
                <!-- Username -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-700">Username</label>
                    <input type="text" x-model="form.username" @input="checkChanges"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Nama Lengkap -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" x-model="form.nama" @input="checkChanges"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Email -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" x-model="form.email" @input="checkChanges"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Password -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-700">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" x-model="form.password" @input="checkChanges"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Akun Google -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-700">Akun Google</label>
                    <template x-if="form.google_id">
                        <div class="flex items-center gap-3">
                            <img :src="form.google_avatar" class="w-10 h-10 rounded-full" alt="Google Avatar">
                            <span class="text-sm text-gray-700 font-medium" x-text="form.google_email"></span>
                            <button @click="disconnectGoogle"
                                class="ml-auto text-red-600 text-xs underline">Putuskan</button>
                        </div>
                    </template>
                    <template x-if="!form.google_id">
                        <button @click="connectGoogle"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
                            Hubungkan Google
                        </button>
                    </template>
                </div>
            </div>

            <!-- Foto dan Status -->
            <div class="space-y-6 flex flex-col items-center">
                <div class="relative w-36 h-36">
                    <img :src="newPhoto || form.photo"
                        class="w-full h-full rounded-full object-cover border-4 border-white shadow-xl transition-all duration-300"
                        alt="Foto Profil">

                    <!-- Overlay Ganti Foto -->
                    <input type="file" class="hidden" id="upload" accept="image/jpeg,image/png" @change="previewPhoto">
                    <label for="upload"
                        class="absolute inset-0 flex items-center justify-center bg-black/50 text-white text-sm font-medium rounded-full opacity-0 hover:opacity-100 transition cursor-pointer">
                        Ganti Foto
                    </label>

                    <!-- Badge Verifikasi -->
                    <div
                        class="flex items-center space-x-1 bg-white rounded-full px-2 py-0.5 mt-4 shadow border border-gray-300">
                        <svg :class="form.status_verifikasi ? 'text-blue-600' : 'text-gray-400'" class="w-[20px] h-[20px]"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs font-semibold"
                            :class="form.status_verifikasi ? 'text-blue-600' : 'text-gray-400'">
                            <template x-if="form.status_verifikasi">
                                <span>Terverifikasi</span>
                            </template>
                            <template x-if="!form.status_verifikasi">
                                <span>Belum Terverifikasi</span>
                            </template>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end mt-10 gap-4">
            <button @click="resetForm"
                class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold">Batal</button>
            <button @click="saveChanges" :disabled="!hasChanged"
                :class="hasChanged ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-blue-200 text-blue-500 cursor-not-allowed'"
                class="px-6 py-2 rounded-lg text-sm font-semibold transition-all">Simpan</button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('editProfile', () => ({
                original: @js([
                    'id_user' => $user->id_user,
                    'username' => $user->username,
                    'nama' => $user->mahasiswa ? $user->mahasiswa->nama : ($user->dosen ? $user->dosen->nama : $user->username),
                    'email' => $user->email,
                    'password' => '',
                    'google_id' => $user->google_id,
                    'google_email' => $user->google_email,
                    'google_avatar' => $user->foto ? asset('profile/admin/' . $user->foto) : 'https://i.pravatar.cc/150?u=' . $user->id_user,
                    'photo' => $user->foto ? asset('profile/admin/' . $user->foto) : '/images/profil-default.jpg',
                    'status_verifikasi' => $user->status_verifikasi,
                ]),
                form: {},
                newPhoto: null,
                hasChanged: false,

                init() {
                    this.form = JSON.parse(JSON.stringify(this.original));
                },

                checkChanges() {
                    this.hasChanged = JSON.stringify(this.form) !== JSON.stringify(this.original) || this.newPhoto !== null;
                },

                previewPhoto(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    // Validasi ukuran file (max 2MB)
                    if (file.size > 2048 * 1024) {
                        alert('Ukuran file maksimal 2MB');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = () => {
                        this.newPhoto = reader.result;
                        this.checkChanges();
                    };
                    reader.readAsDataURL(file);
                },

                resetForm() {
                    this.form = JSON.parse(JSON.stringify(this.original));
                    this.newPhoto = null;
                    this.hasChanged = false;
                },

                saveChanges() {
                    const formData = new FormData();
                    formData.append('username', this.form.username);
                    formData.append('nama', this.form.nama);
                    formData.append('email', this.form.email);
                    if (this.form.password) {
                        formData.append('password', this.form.password);
                    }
                    if (this.newPhoto) {
                        const blob = this.dataURLtoBlob(this.newPhoto);
                        formData.append('foto', blob, 'profile.jpg');
                    }

                    fetch('{{ route('profile.update') }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: formData
                        })
                        .then(async res => {
                            const text = await res.text();
                            if (!res.ok) {
                                console.error('Gagal simpan. Status:', res.status);
                                console.error('Isi respons:', text);
                                alert('Gagal menyimpan. Cek validasi dan koneksi.');
                                return;
                            }
                            const data = JSON.parse(text);
                            alert(data.message);
                            this.original = JSON.parse(JSON.stringify(this.form));
                            if (this.newPhoto) {
                                this.original.photo = URL.createObjectURL(this.dataURLtoBlob(this.newPhoto));
                            }
                            this.newPhoto = null;
                            this.hasChanged = false;
                        })
                        .catch(err => {
                            console.error(err);
                            alert("Terjadi kesalahan saat menyimpan data.");
                        });
                },

                dataURLtoBlob(dataURL) {
                    const arr = dataURL.split(',');
                    const mime = arr[0].match(/:(.*?);/)[1];
                    const bstr = atob(arr[1]);
                    let n = bstr.length;
                    const u8arr = new Uint8Array(n);
                    while (n--) {
                        u8arr[n] = bstr.charCodeAt(n);
                    }
                    return new Blob([u8arr], { type: mime });
                },

                connectGoogle() {
                    // Implementasi koneksi Google
                    alert('Fitur koneksi Google akan diimplementasikan di sini');
                },

                disconnectGoogle() {
                    if (confirm('Anda yakin ingin memutuskan koneksi Google?')) {
                        this.form.google_id = null;
                        this.form.google_email = '';
                        this.form.google_avatar = '';
                        this.checkChanges();
                    }
                }
            }))
        })
    </script>
</x-admin-layout>
