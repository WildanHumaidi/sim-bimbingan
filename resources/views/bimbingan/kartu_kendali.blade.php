<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kendali Bimbingan - {{ $mahasiswa->nama }} ({{ $mahasiswa->id_nim }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                font-size: 11pt;
            }
            .page-break-inside-avoid {
                page-break-inside: avoid;
            }
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900 min-h-screen py-8">

    {{-- Action Bar (No Print) --}}
    <div class="no-print max-w-4xl mx-auto mb-6 px-4 flex justify-between items-center">
        <button onclick="window.history.back()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </button>

        <button onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Simpan PDF
        </button>
    </div>

    {{-- Official Print Container --}}
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 shadow-md print:shadow-none border border-gray-200 print:border-none rounded-xl print:rounded-none">

        {{-- Kop Surat Resmi --}}
        <div class="flex items-center gap-6 border-b-2 border-gray-900 pb-4 mb-6">
            <img src="{{ asset('img/kel32.png') }}" alt="Logo Universitas" class="h-20 w-auto object-contain">
            <div class="text-center flex-1">
                <h2 class="text-xl font-bold tracking-wide uppercase text-gray-900">UNIVERSITAS BINA SARANA INFORMATIKA</h2>
                <h3 class="text-md font-semibold text-gray-700">FAKULTAS TEKNIK & INFORMATIKA</h3>
                <p class="text-xs text-gray-600">Jl. Kramat Raya No.98, Senen, Jakarta Pusat, DKI Jakarta 10450</p>
                <p class="text-xs text-gray-500">Website: www.bsi.ac.id | Email: info@bsi.ac.id</p>
            </div>
        </div>

        {{-- Judul Dokumen --}}
        <div class="text-center mb-8">
            <h1 class="text-lg font-bold uppercase tracking-wider underline text-gray-900">KARTU KENDALI BIMBINGAN TUGAS AKHIR / SKRIPSI</h1>
            <p class="text-xs text-gray-600 mt-1">Tahun Akademik: {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>

        {{-- Informasi Mahasiswa & Dosen --}}
        <div class="grid grid-cols-2 gap-4 text-sm mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200 print:bg-transparent print:border print:p-3">
            <div>
                <table class="w-full">
                    <tr>
                        <td class="w-36 font-semibold py-1 text-gray-700">Nama Mahasiswa</td>
                        <td class="w-4">:</td>
                        <td class="py-1 font-bold text-gray-900">{{ $mahasiswa->nama }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 text-gray-700">NIM</td>
                        <td>:</td>
                        <td class="py-1 text-gray-900">{{ $mahasiswa->id_nim }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 text-gray-700">Program Studi</td>
                        <td>:</td>
                        <td class="py-1 text-gray-900">{{ $mahasiswa->program_studi }}</td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full">
                    <tr>
                        <td class="w-36 font-semibold py-1 text-gray-700">Dosen Pembimbing</td>
                        <td class="w-4">:</td>
                        <td class="py-1 font-bold text-gray-900">{{ $dosen?->nama ?? 'Belum Ditugaskan' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 text-gray-700">NIDN</td>
                        <td>:</td>
                        <td class="py-1 text-gray-900">{{ $dosen?->id_nidn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1 text-gray-700">Status Sidang</td>
                        <td>:</td>
                        <td class="py-1 font-semibold">
                            @if($mahasiswa->status_sidang === 'acc_sidang')
                                <span class="text-green-700 bg-green-100 px-2 py-0.5 rounded text-xs print:text-black print:bg-transparent print:border">ACC SIAP SIDANG</span>
                            @else
                                <span class="text-amber-700 bg-amber-100 px-2 py-0.5 rounded text-xs print:text-black print:bg-transparent">PROSES BIMBINGAN</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-span-2 pt-2 border-t border-gray-200">
                <span class="font-semibold text-gray-700">Judul Skripsi:</span>
                <p class="font-medium text-gray-900 mt-0.5 italic">"{{ $mahasiswa->judul_skripsi ?? 'Judul belum didaftarkan' }}"</p>
            </div>
        </div>

        {{-- Tabel Riwayat Bimbingan --}}
        <div class="mb-8">
            <h4 class="text-sm font-bold uppercase tracking-wide text-gray-800 mb-2">Riwayat Pertemuan Bimbingan</h4>
            <table class="w-full border-collapse border border-gray-400 text-xs">
                <thead>
                    <tr class="bg-gray-100 text-gray-800 text-center font-bold">
                        <th class="border border-gray-400 px-2 py-2 w-10">No</th>
                        <th class="border border-gray-400 px-3 py-2 w-28">Tanggal</th>
                        <th class="border border-gray-400 px-3 py-2">Pokok Bahasan / Bab</th>
                        <th class="border border-gray-400 px-3 py-2">Catatan & Arahan Pembimbing</th>
                        <th class="border border-gray-400 px-2 py-2 w-24">Status</th>
                        <th class="border border-gray-400 px-2 py-2 w-20">Paraf</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bimbinganList as $index => $item)
                        <tr class="page-break-inside-avoid">
                            <td class="border border-gray-400 px-2 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-400 px-3 py-2 text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td class="border border-gray-400 px-3 py-2 font-medium">{{ $item->topik }}</td>
                            <td class="border border-gray-400 px-3 py-2 text-gray-700">{{ $item->catatan ?? '-' }}</td>
                            <td class="border border-gray-400 px-2 py-2 text-center uppercase font-semibold text-[10px]">
                                {{ $item->status_validasi }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2 text-center">
                                @if(strtolower($item->status_validasi) === 'valid')
                                    <span class="text-xs text-blue-800 font-bold">✓ ACC</span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border border-gray-400 px-4 py-6 text-center text-gray-500 italic">
                                Belum ada sesi bimbingan yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Ringkasan Sesi & Catatan Kelayakan --}}
        <div class="mb-8 p-3 border border-gray-300 rounded text-xs bg-gray-50 print:bg-transparent">
            <div class="flex justify-between items-center mb-1">
                <span class="font-bold text-gray-800">Total Bimbingan Disetujui (Valid): {{ $bimbinganList->where('status_validasi', 'valid')->count() }} Sesi</span>
                <span class="font-medium text-gray-600">Standar Minimum Sidang: 8 Sesi</span>
            </div>
            @if($mahasiswa->status_sidang === 'acc_sidang')
                <div class="mt-2 text-green-800 font-medium border-t border-gray-200 pt-2">
                    ✓ Mahasiswa ini telah dinyatakan <strong>LULUS BIMBINGAN / ACC SIDANG</strong> pada tanggal {{ \Carbon\Carbon::parse($mahasiswa->tanggal_acc_sidang)->isoFormat('D MMMM Y') }}.
                    @if($mahasiswa->catatan_acc_sidang)
                        <p class="italic text-gray-700 mt-1">Catatan Pembimbing: "{{ $mahasiswa->catatan_acc_sidang }}"</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Tanda Tangan Pengesahan --}}
        <div class="grid grid-cols-2 gap-8 text-center text-xs page-break-inside-avoid mt-10">
            <div>
                <p class="mb-1 text-gray-600">Mengetahui,</p>
                <p class="font-bold text-gray-800">Ketua Program Studi {{ $mahasiswa->program_studi }}</p>
                <div class="h-20 flex items-center justify-center">
                    {{-- Ruang stempel / paraf kaprodi --}}
                </div>
                <p class="font-bold underline text-gray-900">( .................................................... )</p>
                <p class="text-gray-500">NIDN: .......................................</p>
            </div>
            <div>
                <p class="mb-1 text-gray-600">Jakarta, {{ $tanggalCetak }}</p>
                <p class="font-bold text-gray-800">Dosen Pembimbing Skripsi</p>
                <div class="h-20 flex items-center justify-center">
                    @if($mahasiswa->status_sidang === 'acc_sidang')
                        <span class="text-blue-900 font-serif italic text-sm">Disetujui Secara Digital</span>
                    @endif
                </div>
                <p class="font-bold underline text-gray-900">{{ $dosen?->nama ?? '( .................................................... )' }}</p>
                <p class="text-gray-500">NIDN: {{ $dosen?->id_nidn ?? '.......................................' }}</p>
            </div>
        </div>

    </div>

</body>
</html>
