<x-admin-layout>
    <x-slot:title>Kelola Bimbingan</x-slot>

    <div class="p-4 sm:p-6"
        x-data="{
            showDeleteModal: false,
            selectedBimbingan: {},
            bimbingan: @js($bimbingan->items()),

            resetSelectedBimbingan() {
                this.selectedBimbingan = {};
            },

            setSelectedBimbingan(item) {
                this.selectedBimbingan = { ...item };
            }
        }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Daftar Bimbingan</h1>

            {{-- Tombol Tambah Bimbingan (fix agar pasti bisa diklik) --}}
            <a href="{{ route('bimbingan.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="whitespace-nowrap">Tambah Bimbingan</span>
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel Bimbingan --}}
        <div class="overflow-x-auto">
            <x-table>
                <x-slot name="head">
                    <tr>
                        <th class="px-2 sm:px-4 py-3 text-center">No</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Mahasiswa</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Dosen</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Tanggal</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Status</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Dokumen</th>
                        <th class="px-2 sm:px-4 py-3 text-center">Aksi</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @if($bimbingan->count() === 0)
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-6">Data Bimbingan tidak ditemukan.</td>
                        </tr>
                    @else
                        @foreach($bimbingan as $index => $item)
                            <tr class="even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-2 sm:px-4 py-3 text-center text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-2 sm:px-4 py-3 text-center text-gray-800 font-medium">{{ $item->mahasiswa->nama }}</td>
                                <td class="px-2 sm:px-4 py-3 text-center text-gray-800 font-medium">{{ $item->dosen->nama }}</td>
                                <td class="px-2 sm:px-4 py-3 text-center text-gray-600">{{ $item->tanggal }}</td>
                                <td class="px-2 sm:px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs
                                        {{ $item->status_validasi === 'Pending' ? 'bg-yellow-100 text-yellow-800' :($item->status_validasi === 'Valid' ? 'bg-green-100 text-green-800' :'bg-red-100 text-red-800') }}">
                                        {{ $item->status_validasi }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-4 py-3 text-center">
                                    @foreach($item->dokumen as $dokumen)
                                        <a href="{{ $dokumen->public_url }}" target="_blank" class="block text-blue-600 hover:underline text-sm truncate max-w-[120px] sm:max-w-none mx-auto">
                                            {{ $dokumen->nama_file }}
                                        </a>
                                    @endforeach
                                </td>
                                <td class="px-2 sm:px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('bimbingan.edit', $item->id_bimbingan) }}" class="text-blue-600 hover:text-blue-800 whitespace-nowrap">Edit</a>
                                    <button @click="setSelectedBimbingan(@js($item)); showDeleteModal = true" class="text-red-600 hover:text-red-800 whitespace-nowrap">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </x-slot>
            </x-table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 overflow-x-auto">{{ $bimbingan->links() }}</div>

        {{-- Modal Hapus --}}
        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full sm:w-96 p-4 sm:p-6 text-center">
                <h2 class="text-lg sm:text-xl font-semibold mb-4 text-red-600">Hapus Bimbingan?</h2>
                <p class="mb-4 text-sm sm:text-base">
                    Apakah Anda yakin ingin menghapus bimbingan mahasiswa
                    <strong x-text="selectedBimbingan.mahasiswa?.nama"></strong>
                    dengan dosen <strong x-text="selectedBimbingan.dosen?.nama"></strong>?
                </p>
                <form :action="`/admin/bimbingan/${selectedBimbingan.id_bimbingan}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col sm:flex-row justify-center gap-2 sm:gap-4">
                        <x-button type="button" @click="showDeleteModal = false" variant="secondary" class="w-full sm:w-auto">Batal</x-button>
                        <x-button variant="danger" type="submit" class="w-full sm:w-auto">Hapus</x-button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>
