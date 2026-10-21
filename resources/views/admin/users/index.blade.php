<x-admin-layout>
    <x-slot:title>Daftar Users</x-slot:title>

    <div class="p-4 sm:p-6"
        x-data="{
            showDeleteModal: false,
            selectedUser: {},

            resetSelectedUser() {
                this.selectedUser = {};
            },

            setSelectedUser(item) {
                this.selectedUser = { ...item };
            }
        }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Daftar Users</h1>
                <p class="text-sm text-gray-600">Kelola semua pengguna sistem</p>
            </div>

            {{-- Tombol Tambah User --}}
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="whitespace-nowrap">Tambah User</span>
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                {{ $errors->first('error') }}
            </div>
        @endif

        {{-- Users Table --}}
        <div class="overflow-x-auto">
            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="px-2 sm:px-4 py-3 text-left">User Info</th>
                        <th class="px-2 sm:px-4 py-3 text-left">Role</th>
                        <th class="px-2 sm:px-4 py-3 text-left">Detail Role</th>
                        <th class="px-2 sm:px-4 py-3 text-left">Tanggal Dibuat</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @forelse($users as $user)
                        <tr class="even:bg-gray-50 hover:bg-gray-100">
                            {{-- User Info --}}
                            <td class="px-2 sm:px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">
                                            {{ strtoupper(substr($user->username, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $user->username }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td class="px-2 sm:px-4 py-3">
                                @if($user->role == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9.243 3.03a1 1 0 01.727 1.213L9.53 6h2.94l.56-2.243a1 1 0 111.94.486L14.53 6H17a1 1 0 110 2h-2.97l-1 4H15a1 1 0 110 2h-2.47l-.56 2.242a1 1 0 11-1.94-.485L10.47 14H7.53l-.56 2.242a1 1 0 11-1.94-.485L5.47 14H3a1 1 0 110-2h2.97l1-4H5a1 1 0 110-2h2.47l.56-2.243a1 1 0 011.213-.727zM9.03 8l-1 4h2.94l1-4H9.03z" clip-rule="evenodd"></path>
                                        </svg>
                                        Admin
                                    </span>
                                @elseif($user->role == 2)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                        </svg>
                                        Dosen
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        Mahasiswa
                                    </span>
                                @endif
                            </td>

                            {{-- Detail Role --}}
                            <td class="px-2 sm:px-4 py-3">
                                @if($user->role == 3 && $user->mahasiswa)
                                    <div class="text-sm">
                                        <div class="font-medium">{{ $user->mahasiswa->nama }}</div>
                                        <div class="text-gray-500">NIM: {{ $user->mahasiswa->id_nim }}</div>
                                        <div class="text-gray-500">{{ $user->mahasiswa->program_studi }}</div>
                                    </div>
                                @elseif($user->role == 2 && $user->dosen)
                                    <div class="text-sm">
                                        <div class="font-medium">{{ $user->dosen->nama }}</div>
                                        <div class="text-gray-500">NIDN: {{ $user->dosen->id_nidn }}</div>
                                        <div class="text-gray-500">{{ $user->dosen->jabatan }}</div>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">-</div>
                                @endif
                            </td>

                            {{-- Tanggal Dibuat --}}
                            <td class="px-2 sm:px-4 py-3 text-sm">
                                <div>{{ $user->created_at->format('d M Y') }}</div>
                                <div class="text-gray-500">{{ $user->created_at->format('H:i') }}</div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-2 sm:px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- View Button --}}
                                    <a href="{{ route('admin.show', $user) }}"
                                       class="text-blue-600 hover:text-blue-800"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.edit', $user) }}"
                                       class="text-yellow-600 hover:text-yellow-800"
                                       title="Edit User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    {{-- Delete Button --}}
                                    <button @click="setSelectedUser(@js($user)); showDeleteModal = true"
                                            class="text-red-600 hover:text-red-800"
                                            title="Hapus User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-6">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada user</h3>
                                    <p class="text-gray-500 mb-4">Mulai dengan menambahkan user pertama.</p>
                                    <a href="{{ route('create') }}"
                                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="whitespace-nowrap">Tambah User</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="mt-4 overflow-x-auto">{{ $users->links() }}</div>
        @endif

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full sm:w-96 p-4 sm:p-6 text-center">
                <h2 class="text-lg sm:text-xl font-semibold mb-4 text-red-600">Hapus User?</h2>
                <p class="mb-4 text-sm sm:text-base">
                    Apakah Anda yakin ingin menghapus user
                    <strong x-text="selectedUser.username"></strong>?
                </p>
                <form :action="`/admin/users/${selectedUser.id_user}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col sm:flex-row justify-center gap-2 sm:gap-4">
                        <button type="button" @click="showDeleteModal = false"
                                class="w-full sm:w-auto px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>
