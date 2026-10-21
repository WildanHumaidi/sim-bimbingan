<x-mhs-layout>
    <x-slot:title>Daftar Bimbingan</x-slot:title>

    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8">
        <div class="space-y-1">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Daftar Bimbingan</h1>
            <p class="text-gray-600 text-lg">Kelola jadwal bimbingan dengan dosen pembimbing</p>
        </div>
        <a href="{{ route('mhs.bimbingan.create') }}"
           class="inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 text-white px-9 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02] space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14m-7-7h14"/>
            </svg>
            <span>Tambah Bimbingan</span>
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 text-green-800 px-6 py-4 rounded-xl mb-8 shadow-sm" role="alert">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 pt-0.5">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-green-900">Berhasil!</p>
                    <p class="text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Content Section --}}
    @if($bimbingan->count() > 0)

        {{-- Bimbingan List --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Riwayat Bimbingan</h3>
                        <p class="text-sm text-gray-600 mt-1">Menampilkan {{ $bimbingan->count() }} dari {{ $bimbingan->total() }} bimbingan</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="bg-white rounded-lg px-3 py-2 border border-gray-200 shadow-sm">
                            <span class="text-sm font-medium text-gray-700">Per halaman: {{ $bimbingan->perPage() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-100">
                @foreach($bimbingan as $item)
                    <div class="p-8 hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/30 transition-all duration-200 group">
                        <div class="flex items-start justify-between gap-6">
                            <div class="flex-1 min-w-0">
                                {{-- Header Info --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <h4 class="text-xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors">{{ $item->topik }}</h4>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            @if($item->status_validasi == 'Approved')
                                                bg-green-100 text-green-800 border border-green-200
                                            @elseif($item->status_validasi == 'Rejected')
                                                bg-red-100 text-red-800 border border-red-200
                                            @else
                                                bg-yellow-100 text-yellow-800 border border-yellow-200
                                            @endif">
                                            @if($item->status_validasi == 'Approved')
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif($item->status_validasi == 'Rejected')
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                            {{ $item->status_validasi }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Meta Information --}}
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-5">
                                    <div class="flex items-center space-x-3 text-gray-700">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                <circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Dosen Pembimbing</p>
                                            <p class="font-semibold">{{ $item->dosen->nama ?? 'Dosen tidak ditemukan' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-3 text-gray-700">
                                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                <line x1="16" y1="2" x2="16" y2="6"/>
                                                <line x1="8" y1="2" x2="8" y2="6"/>
                                                <line x1="3" y1="10" x2="21" y2="10"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Tanggal Bimbingan</p>
                                            <p class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-3 text-gray-700">
                                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12,6 12,12 16,14"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Waktu Bimbingan</p>
                                            <p class="font-semibold">
                                                {{ $item->created_at->format('d M Y H:i') }}
                                        @if($item->updated_at->gt($item->created_at))
                                            <br>Diperbarui: {{ $item->updated_at->format('d M Y H:i') }}
                                        @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Additional Info --}}
                                <div class="flex items-center space-x-6">
                                    @if($item->dokumen->count() > 0)
                                        <div class="flex items-center space-x-2 text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                                                <polyline points="14,2 14,8 20,8"/>
                                            </svg>
                                            <span class="font-medium">{{ $item->dokumen->count() }} dokumen</span>
                                        </div>
                                    @endif

                                    @if($item->komentar->count() > 0)
                                        <div class="flex items-center space-x-2 text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10z"/>
                                            </svg>
                                            <span class="font-medium">{{ $item->komentar->count() }} komentar</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col space-y-3 flex-shrink-0">
                                <a href="{{ route('mhs.bimbingan.show', $item->id_bimbingan) }}"
                                   class="inline-flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-md space-x-2 min-w-[100px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span>Detail</span>
                                </a>

                                @if($item->status_validasi == 'Pending')
                                    <a href="{{ route('mhs.bimbingan.edit', $item->id_bimbingan) }}"
                                       class="inline-flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-md space-x-2 min-w-[100px]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('mhs.bimbingan.destroy', $item->id_bimbingan) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-md space-x-2 min-w-[100px]"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus bimbingan ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3,6 5,6 21,6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($bimbingan->hasPages())
                <div class="px-8 py-6 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ $bimbingan->firstItem() }} - {{ $bimbingan->lastItem() }} dari {{ $bimbingan->total() }} hasil
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $bimbingan->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="text-center py-20 px-8">
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Bimbingan</h3>
                <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto leading-relaxed">
                    Buat jadwal bimbingan dengan dosen untuk memulai proses pembimbingan dan monitoring progress Anda.
                </p>
                <a href="{{ route('mhs.bimbingan.create') }}"
                   class="inline-flex items-center space-x-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14m-7-7h14"/>
                    </svg>
                    <span>Buat Jadwal Bimbingan</span>
                </a>
            </div>
        </div>
    @endif
</x-mhs-layout>
