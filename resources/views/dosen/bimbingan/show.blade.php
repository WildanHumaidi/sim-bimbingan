<x-dosen-layout>
    <x-slot:title>Detail Bimbingan - {{ $bimbingan->mahasiswa->nama }}</x-slot:title>

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Bimbingan</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap bimbingan mahasiswa</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('dosen.bimbingan.index') }}"
                class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="mr-2">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                Kembali ke Daftar Bimbingan
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-8 shadow-sm"
            role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-5 w-5 text-green-600 mr-3" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div x-data="{ showPdf: false, pdfUrl: '' }">
        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">

            {{-- Card Informasi Mahasiswa --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Mahasiswa</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-14 w-14">
                            <div
                                class="h-14 w-14 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                                <span class="text-lg font-semibold text-white">
                                    {{ substr($bimbingan->mahasiswa->nama, 0, 2) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 mb-1">Nama Mahasiswa</p>
                            <p class="text-base font-semibold text-gray-900 truncate">{{ $bimbingan->mahasiswa->nama }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">NIM</p>
                            <p class="text-base font-medium text-gray-900">{{ $bimbingan->mahasiswa->id_nim }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Program Studi</p>
                            <p class="text-base font-medium text-gray-900">{{ $bimbingan->mahasiswa->program_studi }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Detail Bimbingan --}}
            <div class="xl:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Detail Bimbingan</h3>
                </div>
                <div class="p-6 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Tanggal Bimbingan</p>
                            <div class="flex items-center bg-gray-50 rounded-lg p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="mr-3 text-gray-500">
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

                        <div>
                            <p class="text-sm text-gray-500 mb-2">Status Validasi</p>
                            @php
    $statusConfig = [
        'valid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200'],
        'invalid' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200'],
        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200'],
    ];
    $status = strtolower($bimbingan->status_validasi);
    $config = $statusConfig[$status] ?? $statusConfig['pending'];
@endphp
<span class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
    @switch($status)
        @case('valid')
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <path d="M9 11l3 3L22 4" />
            </svg>
            Valid
            @break

        @case('invalid')
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <circle cx="12" cy="12" r="10" />
                <path d="m15 9-6 6" />
                <path d="m9 9 6 6" />
            </svg>
            Invalid
            @break

        @default
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12,6 12,12 16,14" />
            </svg>
            Pending
    @endswitch
</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-3">Topik Bimbingan</p>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-base text-gray-900 whitespace-pre-line leading-relaxed">
                                {{ $bimbingan->topik }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-3">Catatan Dosen</p>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-base text-gray-900 whitespace-pre-line leading-relaxed">
                                {{ $bimbingan->catatan ?? 'Tidak ada catatan dari dosen' }}
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
                                            <button @click="showPdf = true; pdfUrl = '{{ $dokumen->public_url }}'"
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


        {{-- Section Komentar --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Komentar Bimbingan</h3>
            </div>

            {{-- Scrollable Comments Area --}}
            <div class="max-h-96 overflow-y-auto">
                <div class="p-6">
                    @if ($bimbingan->komentar->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Belum ada komentar</h4>
                            <p class="text-gray-500">Tambahkan komentar pertama untuk bimbingan ini</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($bimbingan->komentar->sortBy('waktu_kirim') as $komentar)
                                @if ($komentar->tipe_pengirim === 'dosen')
                                    {{-- Komentar Dosen - Kanan --}}
                                    <div class="flex items-start gap-4 justify-end">
                                        <div class="flex-1 max-w-xs sm:max-w-md">
                                            <div
                                                class="bg-blue-50 border border-blue-200 rounded-lg rounded-tr-none p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center gap-2">
                                                        <p class="text-sm font-semibold text-blue-900">
                                                            @if ($komentar->pengirim->dosen)
                                                                {{ $komentar->pengirim->dosen->nama }}
                                                            @else
                                                                {{ $komentar->pengirim->name }}
                                                            @endif
                                                        </p>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            Dosen
                                                        </span>
                                                    </div>
                                                </div>
                                                <p
                                                    class="text-sm text-gray-700 whitespace-pre-line leading-relaxed mb-2">
                                                    {{ $komentar->isi_komentar }}
                                                </p>
                                                @if ($komentar->lampiran_url)
                                                    <div class="mt-3 pt-3 border-t border-blue-200">
                                                        <a href="{{ $komentar->lampiran_url }}" target="_blank"
                                                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-100 px-3 py-1 rounded-lg transition-colors duration-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-2" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                            Lihat Lampiran
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="mt-2 text-right">
                                                    <p class="text-xs text-gray-500">
                                                        {{ \Carbon\Carbon::parse($komentar->waktu_kirim)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-12 w-12 rounded-full flex items-center justify-center shadow-sm bg-gradient-to-br from-blue-500 to-blue-600">
                                                <span class="text-sm font-semibold text-white">
                                                    @if ($komentar->pengirim->dosen)
                                                        {{ substr($komentar->pengirim->dosen->nama, 0, 2) }}
                                                    @else
                                                        {{ substr($komentar->pengirim->name, 0, 2) }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Komentar Mahasiswa - Kiri --}}
                                    <div class="flex items-start gap-4 justify-start">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-12 w-12 rounded-full flex items-center justify-center shadow-sm bg-gradient-to-br from-green-500 to-green-600">
                                                <span class="text-sm font-semibold text-white">
                                                    @if ($komentar->pengirim->mahasiswa)
                                                        {{ substr($komentar->pengirim->mahasiswa->nama, 0, 2) }}
                                                    @else
                                                        {{ substr($komentar->pengirim->name, 0, 2) }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1 max-w-xs sm:max-w-md">
                                            <div
                                                class="bg-green-50 border border-green-200 rounded-lg rounded-tl-none p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center gap-2">
                                                        <p class="text-sm font-semibold text-green-900">
                                                            @if ($komentar->pengirim->mahasiswa)
                                                                {{ $komentar->pengirim->mahasiswa->nama }}
                                                            @else
                                                                {{ $komentar->pengirim->name }}
                                                            @endif
                                                        </p>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Mahasiswa
                                                        </span>
                                                    </div>
                                                </div>
                                                <p
                                                    class="text-sm text-gray-700 whitespace-pre-line leading-relaxed mb-2">
                                                    {{ $komentar->isi_komentar }}
                                                </p>
                                                @if ($komentar->lampiran_url)
                                                    <div class="mt-3 pt-3 border-t border-green-200">
                                                        <a href="{{ $komentar->lampiran_url }}" target="_blank"
                                                            class="inline-flex items-center text-sm text-green-600 hover:text-green-800 hover:bg-green-100 px-3 py-1 rounded-lg transition-colors duration-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-2" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                            Lihat Lampiran
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="mt-2">
                                                    <p class="text-xs text-gray-500">
                                                        {{ \Carbon\Carbon::parse($komentar->waktu_kirim)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Form Komentar --}}
            <div class="px-6 py-5 border-t border-gray-200 bg-gray-50">
                <form action="{{ route('bimbingan.komentar.store', $bimbingan->id_bimbingan) }}" method="POST"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label for="komentar" class="block text-sm font-medium text-gray-700 mb-2">Tambah
                            Komentar</label>
                        <textarea id="komentar" name="komentar" rows="4"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none transition-colors duration-200"
                            placeholder="Tulis komentar Anda..." required></textarea>
                    </div>
                    <div>
                        <label for="lampiran_url" class="block text-sm font-medium text-gray-700 mb-2">Link Lampiran
                            (Opsional)</label>
                        <input type="url" id="lampiran_url" name="lampiran_url"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200"
                            placeholder="https://example.com">
                    </div>
                    <div class="flex justify-center pt-2">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
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

        {{-- Action Buttons --}}
        <div class="flex justify-end space-x-4 pb-8">
            <a href="{{ route('dosen.bimbingan.edit', $bimbingan->id_bimbingan) }}"
                class="inline-flex items-center px-6 py-3 bg-yellow-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="mr-2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Edit Bimbingan
            </a>
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
</x-dosen-layout>
