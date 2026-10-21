<x-admin-layout>
    <x-slot:title>Kelola Tahun Ajar</x-slot>

    <div class="p-6" x-data="{
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedTahunAjar: { tahun: '', semester: '', id_tahun: null },
        tahunAjar: @js($tahunAjar->items()),

        // Helper methods
        resetSelectedTahunAjar() {
            this.selectedTahunAjar = { tahun: '', semester: '', id_tahun: null };
        },
        setSelectedTahunAjar(item) {
            this.selectedTahunAjar = { ...item };
        }
    }">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Tahun Ajar</h1>
            <x-button @click="resetSelectedTahunAjar(); showAddModal = true">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Tambah Tahun Ajar</span>
            </x-button>
        </div>

        {{-- Tabel Tahun Ajar --}}
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3 text-center">Tahun</th>
                    <th class="px-4 py-3 text-center">Semester</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                <template x-if="tahunAjar.length === 0">
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-6">Data Tahun Ajar tidak ditemukan.</td>
                    </tr>
                </template>
                <template x-for="(item, index) in tahunAjar" :key="item.id_tahun">
                    <tr class="even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-4 py-3 text-center text-gray-600" x-text="index + 1"></td>
                        <td class="px-4 py-3 text-gray-800 font-medium text-center" x-text="item.tahun"></td>
                        <td class="px-4 py-3 text-center">
                            <span x-text="item.semester"
                                  :class="{
                                      'bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs': item.semester === 'Ganjil',
                                      'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs': item.semester === 'Genap'
                                  }"></span>
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button @click="setSelectedTahunAjar(item); showDetailModal = true"
                                class="text-blue-600 hover:text-blue-800">Detail</button>
                            <button @click="setSelectedTahunAjar(item); showEditModal = true"
                                class="text-yellow-600 hover:text-yellow-800">Edit</button>
                            <button @click="setSelectedTahunAjar(item); showDeleteModal = true"
                                class="text-red-600 hover:text-red-800">Hapus</button>
                        </td>
                    </tr>
                </template>
            </x-slot>
        </x-table>

        {{-- Pagination --}}
        <div class="mt-4">{{ $tahunAjar->links() }}</div>

        {{-- Flash Message --}}
        <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }"
             x-init="setTimeout(() => { showSuccess = false; showError = false }, 3000)"
             class="fixed top-5 right-5 z-50 space-y-2">

            <div x-show="showSuccess" x-transition
                class="flex items-center gap-3 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>

            <div x-show="showError" x-transition
                class="flex items-center gap-3 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <x-modal show="showAddModal" title="Tambah Tahun Ajar Baru">
            <form action="{{ route('tahun_ajar.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="tahun" class="block text-sm font-medium">Tahun</label>
                        <input type="text" placeholder="Contoh: 2023/2024" id="tahun" name="tahun"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-medium">Semester</label>
                        <select id="semester" name="semester"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="showAddModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Detail --}}
        <x-modal show="showDetailModal" title="Detail Tahun Ajar">
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">Tahun</p>
                    <p class="font-medium text-gray-800" x-text="selectedTahunAjar.tahun"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">Semester</p>
                    <p class="font-medium text-gray-800" x-text="selectedTahunAjar.semester"></p>
                </div>
            </div>
            <div class="text-right pt-4">
                <x-button variant="primary" @click="showDetailModal = false">Tutup</x-button>
            </div>
        </x-modal>

        {{-- Modal Edit --}}
        <x-modal show="showEditModal" title="Edit Tahun Ajar">
            <form :action="`{{ url('/admin/tahun_ajar') }}/${selectedTahunAjar.id_tahun}`" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="tahun" class="block text-sm font-medium">Tahun</label>
                        <input type="text" x-model="selectedTahunAjar.tahun" id="tahun" name="tahun"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-medium">Semester</label>
                        <select id="semester" name="semester" x-model="selectedTahunAjar.semester"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="showEditModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Hapus --}}
        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-96 p-6 text-center">
                <h2 class="text-xl font-semibold mb-4 text-red-600">Hapus Tahun Ajar?</h2>
                <p class="mb-4">Apakah Anda yakin ingin menghapus tahun ajar <strong x-text="selectedTahunAjar.tahun"></strong> semester <strong x-text="selectedTahunAjar.semester"></strong>?</p>
                <form :action="`{{ url('/admin/tahun_ajar') }}/${selectedTahunAjar.id_tahun}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-4">
                        <x-button type="button" @click="showDeleteModal = false" variant="secondary">Batal</x-button>
                        <x-button variant="danger" type="submit">Hapus</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
