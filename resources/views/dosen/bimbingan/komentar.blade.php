<x-dosen-layout>
    <x-slot:title>Komentar Bimbingan</x-slot>

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Komentar Bimbingan</h1>
            <p class="text-gray-600">Diskusi bimbingan dengan mahasiswa</p>
        </div>
        <a href="{{ route('dosen.bimbingan.show', $bimbingan->id_bimbingan) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Bimbingan Info --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <span class="text-sm font-medium text-blue-600">
                        {{ substr($bimbingan->mahasiswa->nama, 0, 2) }}
                    </span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $bimbingan->mahasiswa->nama }}</h3>
                    <p class="text-sm text-gray-500">NIM: {{ $bimbingan->mahasiswa->id_nim }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        <span class="font-medium">Topik:</span> {{ $bimbingan->topik }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Komentar Section --}}
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Diskusi Bimbingan</h3>
        </div>

        @if(isset($komentars) && $komentars->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($komentars as $komentar)
                    <div class="px-4 py-5 sm:p-6 hover:bg-gray-50">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 rounded-full {{ $komentar->tipe_pengirim === 'dosen' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }} flex items-center justify-center">
                                    <span class="text-sm font-medium">
                                        {{ $komentar->tipe_pengirim === 'dosen' ? 'DSN' : 'MHS' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $komentar->tipe_pengirim === 'dosen' ? 'Anda' : $bimbingan->mahasiswa->nama }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($komentar->waktu_kirim)->locale('id')->diffForHumans() }}
                                    </p>
                                </div>
                                <p class="mt-1 text-sm text-gray-600 whitespace-pre-line">{{ $komentar->isi_komentar }}</p>

                                @if($komentar->lampiran_url)
                                    <div class="mt-2">
                                        <a href="{{ $komentar->lampiran_url }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>

                            @if($komentar->tipe_pengirim === 'dosen' && $komentar->id_pengirim === auth()->id())
                                <div class="ml-4 flex-shrink-0">
                                    <form action="{{ route('dosen.komentar.destroy', $komentar->id_komentar) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="px-4 py-12 text-center sm:px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada komentar</h3>
                <p class="mt-1 text-sm text-gray-500">Mulailah diskusi dengan mahasiswa Anda.</p>
            </div>
        @endif
    </div>

    {{-- Add Comment Form --}}
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Komentar</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('bimbingan.komentar.store', $bimbingan->id_bimbingan) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="komentar" class="block text-sm font-medium text-gray-700">Isi Komentar</label>
                        <div class="mt-1">
                            <textarea id="komentar" name="komentar" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Tulis komentar Anda di sini..." required>{{ old('komentar') }}</textarea>
                        </div>
                        @error('komentar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lampiran_url" class="block text-sm font-medium text-gray-700">URL Lampiran (Opsional)</label>
                        <div class="mt-1">
                            <input type="url" id="lampiran_url" name="lampiran_url" value="{{ old('lampiran_url') }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="https://example.com/file.pdf">
                        </div>
                        @error('lampiran_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Kirim Komentar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dosen-layout>
