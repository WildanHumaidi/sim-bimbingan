<x-admin-layout>
    <x-slot:title>Kelola Program Studi</x-slot>

    <div class="p-6" x-data="{
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        selectedProdi: { id_prodi: null, nama_prodi: '', fakultas: '' },
        programStudi: @js($programStudi->items()),

        resetSelectedProdi() {
            this.selectedProdi = { id_prodi: null, nama_prodi: '', fakultas: '' };
        },
        setSelectedProdi(item) {
            this.selectedProdi = { ...item };
        }
    }">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Program Studi</h1>
            <x-button @click="resetSelectedProdi(); showAddModal = true">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Program Studi
            </x-button>
        </div>

        {{-- Tabel --}}
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3 text-center">Nama Program Studi</th>
                    <th class="px-4 py-3 text-center">Fakultas</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                <template x-if="programStudi.length === 0">
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-6">Data tidak ditemukan.</td>
                    </tr>
                </template>
                <template x-for="(item, index) in programStudi" :key="item.id_prodi">
                    <tr class="even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-4 py-3 text-center" x-text="index + 1"></td>
                        <td class="px-4 py-3 text-center" x-text="item.nama_prodi"></td>
                        <td class="px-4 py-3 text-center" x-text="item.fakultas"></td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button @click="setSelectedProdi(item); showEditModal = true"
                                class="text-yellow-600 hover:text-yellow-800 px-2 py-1 rounded hover:bg-yellow-50">
                                Edit
                            </button>
                            <button @click="setSelectedProdi(item); showDeleteModal = true"
                                class="text-red-600 hover:text-red-800 px-2 py-1 rounded hover:bg-red-50">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </template>
            </x-slot>
        </x-table>

        {{-- Pagination --}}
        <div class="mt-4">{{ $programStudi->links() }}</div>

        {{-- Modal Tambah --}}
        <x-modal show="showAddModal" title="Tambah Program Studi">
            <form action="{{ route('program_studi.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nama_prodi" class="block text-sm font-medium text-gray-700 mb-1">Nama Program Studi</label>
                        <input type="text" id="nama_prodi" name="nama_prodi" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <input type="text" id="fakultas" name="fakultas" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="showAddModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Edit --}}
        <x-modal show="showEditModal" title="Edit Program Studi">
            <form :action="`{{ url('/admin/program_studi') }}/${selectedProdi.id_prodi}`" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="edit_nama_prodi" class="block text-sm font-medium text-gray-700 mb-1">Nama Program Studi</label>
                        <input type="text" id="edit_nama_prodi" name="nama_prodi" x-model="selectedProdi.nama_prodi" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="edit_fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <input type="text" id="edit_fakultas" name="fakultas" x-model="selectedProdi.fakultas" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="showEditModal = false" variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal Hapus --}}
        <x-modal show="showDeleteModal" title="Hapus Program Studi" max-width="sm">
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Apakah Anda yakin ingin menghapus program studi <span class="font-semibold" x-text="selectedProdi.nama_prodi"></span>?</h3>
                <form :action="`{{ url('/admin/program_studi') }}/${selectedProdi.id_prodi}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-4 mt-6">
                        <x-button type="button" @click="showDeleteModal = false" variant="secondary">Batal</x-button>
                        <x-button variant="danger" type="submit">Hapus</x-button>
                    </div>
                </form>
            </div>
        </x-modal>

    </div>
</x-admin-layout>
