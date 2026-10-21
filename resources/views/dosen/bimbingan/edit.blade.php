<x-dosen-layout>
    <x-slot:title>Edit Bimbingan - {{ $bimbingan->mahasiswa->nama }}</x-slot:title>

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Bimbingan</h1>
            <p class="text-gray-600">Ubah status validasi dan catatan bimbingan</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('dosen.bimbingan.show', $bimbingan->id_bimbingan) }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="mr-2">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                Kembali ke Detail
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div x-data="{ showPdf: false, pdfUrl: '' }">
        <form action="{{ route('dosen.bimbingan.update', $bimbingan->id_bimbingan) }}" method="POST" class="pb-10">
            @csrf
            @method('PUT')

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">

                {{-- Card Informasi Mahasiswa --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Mahasiswa</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-lg font-medium text-blue-600">
                                        {{ substr($bimbingan->mahasiswa->nama, 0, 2) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-500">Nama Mahasiswa</p>
                                <p class="text-base font-semibold text-gray-900 truncate">
                                    {{ $bimbingan->mahasiswa->nama }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">NIM</p>
                            <p class="text-base font-medium text-gray-900">{{ $bimbingan->mahasiswa->id_nim }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Program Studi</p>
                            <p class="text-base font-medium text-gray-900">{{ $bimbingan->mahasiswa->program_studi }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Detail Bimbingan --}}
                <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Detail Bimbingan</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tanggal Bimbingan</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-gray-400">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    <p class="text-base font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($bimbingan->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Status Validasi Section --}}
                            <div>
                                <label for="status_validasi" class="block text-sm text-gray-500 mb-1">Status Validasi</label>
                                <div class="relative">
                                    <select name="status_validasi" id="status_validasi" required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium">
                                        @foreach(['Pending', 'Valid', 'Invalid'] as $status)
                                            <option value="{{ $status }}"
                                                {{ $bimbingan->status_validasi == $status ? 'selected' : '' }}
                                                class="{{ [
                                                    'Valid' => 'text-green-800',
                                                    'Invalid' => 'text-red-800',
                                                    'Pending' => 'text-yellow-800'
                                                ][$status] ?? '' }}">
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Status Indicator --}}
                                <div class="mt-2">
                                    @php
                                        $statusClasses = [
                                            'Valid' => 'bg-green-100 text-green-800 border-green-200',
                                            'Invalid' => 'bg-red-100 text-red-800 border-red-200',
                                            'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200'
                                        ];
                                        $currentStatus = $bimbingan->status_validasi;
                                    @endphp
                                    <span id="status-indicator" class="px-3 py-1 text-sm font-medium rounded-full border transition-all duration-200 {{ $statusClasses[$currentStatus] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                        <span id="status-text">{{ $currentStatus }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-2">Topik Bimbingan</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-base text-gray-900 whitespace-pre-line">{{ $bimbingan->topik }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm text-gray-500 mb-2">Catatan Dosen</label>
                            <textarea name="catatan" id="catatan" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium"
                                placeholder="Tambahkan catatan untuk mahasiswa">{{ old('catatan', $bimbingan->catatan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Dokumen --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Dokumen Bimbingan</h3>
                        @if (!$bimbingan->dokumen->isEmpty())
                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                    <polyline points="14,2 14,8 20,8" />
                                </svg>
                                {{ $bimbingan->dokumen->count() }} file
                            </span>
                        @endif
                    </div>
                </div>

                @if ($bimbingan->dokumen->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round" class="mx-auto text-gray-400 mb-4">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                            <polyline points="14,2 14,8 20,8" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada dokumen</h3>
                        <p class="text-gray-500">Belum ada dokumen yang diunggah untuk bimbingan ini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Dokumen</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Upload</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($bimbingan->dokumen as $index => $dokumen)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="text-red-600">
                                                            <path
                                                                d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                                            <polyline points="14,2 14,8 20,8" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $dokumen->nama_file }}</div>
                                                    <div class="text-sm text-gray-500">PDF Document</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($dokumen->uploaded_at)->isoFormat('D MMMM Y, HH:mm') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <button @click="showPdf = true; pdfUrl = '{{ $dokumen->public_url }}'"
                                                    type="button"
                                                    class="text-blue-600 hover:text-blue-900 p-1 rounded"
                                                    title="Lihat Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                        <circle cx="12" cy="12" r="3" />
                                                    </svg>
                                                </button>
                                                <a href="{{ $dokumen->public_url }}" download
                                                    class="text-green-600 hover:text-green-900 p-1 rounded"
                                                    title="Unduh">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                        <polyline points="7,10 12,15 17,10" />
                                                        <line x1="12" y1="15" x2="12"
                                                            y2="3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Submit buttons --}}
            <div class="mt-6 mb-10 flex justify-end space-x-3">
                <button type="button" onclick="window.history.back()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="inline mr-2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17,21 17,13 7,13 7,21" />
                        <polyline points="7,3 7,8 15,8" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

        {{-- Modal PDF Viewer --}}
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" x-show="showPdf"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white w-full max-w-6xl h-[90vh] mx-4 rounded-2xl shadow-2xl relative"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">

                <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t-2xl bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Preview Dokumen</h3>
                    <button class="text-gray-400 hover:text-gray-600 transition-colors" @click="showPdf = false"
                        aria-label="Tutup modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                <div class="h-full p-6 pb-12">
                    <iframe :src="pdfUrl" class="w-full h-full rounded-lg border border-gray-200"
                        type="application/pdf">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('status_validasi');
            const indicator = document.getElementById('status-indicator');
            const statusText = document.getElementById('status-text');

            // Status color mapping
            const statusClasses = {
                'Valid': 'bg-green-100 text-green-800 border-green-200',
                'Invalid': 'bg-red-100 text-red-800 border-red-200',
                'Pending': 'bg-yellow-100 text-yellow-800 border-yellow-200'
            };

            function updateStatusIndicator() {
                const value = select.value;

                // Reset classes
                indicator.className = 'px-3 py-1 text-sm font-medium rounded-full border transition-all duration-200';

                // Add new status class
                if (statusClasses[value]) {
                    indicator.classList.add(...statusClasses[value].split(' '));
                }

                statusText.textContent = value;
            }

            // Initialize
            updateStatusIndicator();

            // Update on change
            select.addEventListener('change', updateStatusIndicator);
        });
    </script>
</x-dosen-layout>
