<x-mhs-layout>
    <x-slot:title>Detail Bimbingan</x-slot:title>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Detail Bimbingan</h1>
            <p class="text-gray-600 mt-1">Sesi bimbingan dengan {{ $bimbingan->dosen->nama }}</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('mhs.bimbingan.index') }}"
                class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Bimbingan
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div x-data="{ showPdf: false, pdfUrl: '' }">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
            {{-- Card Informasi Dosen --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Dosen Pembimbing</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-12 w-12">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                                <span class="text-lg font-semibold text-white">
                                    {{ substr($bimbingan->dosen->nama, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 mb-1">Nama Dosen</p>
                            <p class="text-base font-semibold text-gray-900 truncate">{{ $bimbingan->dosen->nama }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Fakultas</p>
                        <p class="text-base font-medium text-gray-900">{{ $bimbingan->dosen->fakultas ?? 'Belum ditentukan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Bidang Keahlian</p>
                        <p class="text-base font-medium text-gray-900">{{ $bimbingan->dosen->bidang_keahlian ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Card Detail Bimbingan --}}
            <div class="xl:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Detail Bimbingan</h3>
                </div>
                <div class="p-5 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Tanggal Bimbingan</p>
                            <div class="flex items-center bg-gray-50 rounded-lg p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-base font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($bimbingan->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Status</p>
                            @php
                                $statusConfig = [
                                    'Valid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200'],
                                    'Invalid' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200'],
                                    'Pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200'],
                                ];
                                $config = $statusConfig[$bimbingan->status_validasi] ?? $statusConfig['Pending'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                @switch($bimbingan->status_validasi)
                                    @case('Valid')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @break

                                    @case('Invalid')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @break

                                    @default
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                @endswitch
                                {{ $bimbingan->status_validasi }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-2">Topik Bimbingan</p>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-base text-gray-900 whitespace-pre-line">{{ $bimbingan->topik }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-2">Catatan Mahasiswa</p>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-base text-gray-900 whitespace-pre-line">
                                {{ $bimbingan->catatan ?? 'Belum ada catatan dari Mahasiswa' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Dokumen --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Dokumen Bimbingan</h3>
                    @if (!$bimbingan->dokumen->isEmpty())
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
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
                <div class="px-6 py-16 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="mx-auto text-gray-300 mb-4">
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
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Dokumen</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Upload</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($bimbingan->dokumen as $index => $dokumen)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div
                                                    class="h-12 w-12 rounded-lg bg-red-50 flex items-center justify-center border border-red-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                        height="22" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="text-red-600">
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
                                        <div class="flex items-center space-x-3">
                                            <button
                                                @click="showPdf = true; pdfUrl = '{{ $dokumen->public_url }}'"
                                                class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                                title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                            <a href="{{ $dokumen->public_url }}" download
                                                class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                                title="Unduh">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

        {{-- Section Komentar dengan Layout Chat --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Diskusi Bimbingan</h3>
            </div>

            {{-- Daftar Komentar --}}
            <div class="max-h-96 overflow-y-auto p-6 space-y-4">
                @forelse ($bimbingan->komentar->sortBy('waktu_kirim') as $komentar)
                    @if($komentar->tipe_pengirim === 'dosen')
                        {{-- Komentar Dosen - Kiri --}}
                        <div class="flex gap-4 justify-start">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center bg-blue-500 text-white">
                                    {{ substr($komentar->pengirim->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1 max-w-xs sm:max-w-md">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg rounded-tl-none p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium text-blue-900">
                                            {{ $komentar->pengirim->name }}
                                            <span class="text-xs px-2 py-1 ml-2 rounded bg-blue-100 text-blue-800">
                                                Dosen
                                            </span>
                                        </span>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $komentar->isi_komentar }}</p>
                                    @if($komentar->lampiran_url)
                                        <div class="mt-2">
                                            <a href="{{ $komentar->lampiran_url }}" target="_blank" class="text-blue-600 text-sm flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                                Lampiran
                                            </a>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <span class="text-xs text-gray-500">
                                            {{ $komentar->waktu_kirim->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Komentar Mahasiswa - Kanan --}}
                        <div class="flex gap-4 justify-end">
                            <div class="flex-1 max-w-xs sm:max-w-md">
                                <div class="bg-green-50 border border-green-200 rounded-lg rounded-tr-none p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium text-green-900">
                                            {{ $komentar->pengirim->name }}
                                            <span class="text-xs px-2 py-1 ml-2 rounded bg-green-100 text-green-800">
                                                Anda
                                            </span>
                                        </span>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $komentar->isi_komentar }}</p>
                                    @if($komentar->lampiran_url)
                                        <div class="mt-2">
                                            <a href="{{ $komentar->lampiran_url }}" target="_blank" class="text-green-600 text-sm flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                                Lampiran
                                            </a>
                                        </div>
                                    @endif
                                    <div class="mt-2 text-right">
                                        <span class="text-xs text-gray-500">
                                            {{ $komentar->waktu_kirim->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center bg-green-500 text-white">
                                    {{ substr($komentar->pengirim->name, 0, 1) }}
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center py-8 text-gray-500">
                        Belum ada diskusi pada bimbingan ini
                    </div>
                @endforelse
            </div>

            {{-- Form Komentar --}}
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <form action="{{ route('bim.komentar.store', $bimbingan->id_bimbingan) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <textarea name="komentar" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tulis komentar Anda..." required></textarea>
                    </div>
                    <div class="mb-4">
                        <input type="url" name="lampiran_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Link lampiran (opsional)">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal PDF Viewer --}}
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4" x-show="showPdf"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showPdf = false">
            <div class="bg-white w-full max-w-6xl h-[90vh] rounded-xl shadow-2xl relative overflow-hidden"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95" @click.stop>

                <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Preview Dokumen</h3>
                    <button
                        class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200"
                        @click="showPdf = false" aria-label="Tutup modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                <div class="h-full p-6 pb-12">
                    <iframe :src="pdfUrl" class="w-full h-full rounded-lg border border-gray-200 shadow-sm"
                        type="application/pdf">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</x-mhs-layout>
