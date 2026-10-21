<x-mhs-layout>
    <x-slot:title>Tambah Bimbingan</x-slot:title>

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Tambah Bimbingan</h1>
            <p class="text-gray-600 mt-1 md:mt-2 text-sm md:text-base">Buat jadwal bimbingan baru dengan dosen pembimbing</p>
        </div>
        <a href="{{ route('mhs.bimbingan.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 md:px-6 md:py-3 rounded-lg md:rounded-xl flex items-center space-x-2 transition-colors w-full md:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H6m0 0l4 4m-4-4l4-4"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Alert Messages --}}
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-8" role="alert">
            <div class="flex items-start">
                <svg class="flex-shrink-0 h-5 w-5 text-red-500 mt-0.5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold">Terdapat kesalahan!</p>
                    <ul class="mt-1 list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Section --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Form Tambah Bimbingan</h3>
            <p class="text-sm text-gray-600 mt-1">Lengkapi data bimbingan dengan dosen pembimbing</p>
        </div>

        <form action="{{ route('mhs.bimbingan.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            {{-- Dosen Pembimbing Section --}}
            <div class="mb-6">
                <label for="nidn" class="block text-sm font-medium text-gray-700 mb-2">
                    Dosen Pembimbing <span class="text-red-500">*</span>
                </label>
                <select name="nidn" id="nidn"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nidn') border-red-500 @enderror transition-colors">
                    <option value="">Pilih Dosen Pembimbing</option>
                    @if(isset($dosen))
                        @foreach($dosen as $item)
                            <option value="{{ $item->id_nidn }}" {{ old('nidn') == $item->id_nidn ? 'selected' : '' }}>
                                {{ $item->nidn }} - {{ $item->nama }} ({{ $item->fakultas ?? '-' }})
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('nidn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Topik Bimbingan Section --}}
            <div class="mb-6">
                <label for="topik" class="block text-sm font-medium text-gray-700 mb-2">
                    Topik Bimbingan <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="topik"
                       id="topik"
                       value="{{ old('topik') }}"
                       placeholder="Masukkan topik bimbingan"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('topik') border-red-500 @enderror transition-colors">
                @error('topik')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Bimbingan Section --}}
            <div class="mb-6">
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Bimbingan <span class="text-red-500">*</span>
                </label>
                <input type="date"
                       name="tanggal"
                       id="tanggal"
                       value="{{ old('tanggal') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal') border-red-500 @enderror transition-colors">
                @error('tanggal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi Section --}}
            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Bimbingan <span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="4"
                          placeholder="Jelaskan detail bimbingan yang akan dilakukan..."
                          class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror transition-colors resize-vertical">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload Dokumen Section --}}
            <div class="mb-8">
                <label for="dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                    Dokumen Pendukung (akan disimpan di public/doc)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <input type="file"
                           name="dokumen[]"
                           id="dokumen"
                           multiple
                           accept=".pdf,.doc,.docx"
                           class="hidden"
                           onchange="updateFileList(this)">
                    <label for="dokumen" class="cursor-pointer">
                        <span class="text-blue-600 hover:text-blue-700 font-medium">Klik untuk upload</span>
                        <span class="text-gray-600"> atau drag & drop file</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-2">Format: PDF, DOC, DOCX (Maksimal 2MB per file)</p>
                    <div id="file-list" class="mt-3 text-left space-y-2"></div>
                </div>
                @error('dokumen.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse md:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('mhs.bimbingan.index') }}"
                   class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors font-medium text-center">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center space-x-2 transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span>Simpan Bimbingan</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function updateFileList(input) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';

            if (input.files.length > 0) {
                const listHeader = document.createElement('p');
                listHeader.className = 'text-sm font-medium text-gray-700 mb-2';
                listHeader.textContent = `File dipilih (${input.files.length}):`;
                fileList.appendChild(listHeader);

                const listContainer = document.createElement('div');
                listContainer.className = 'space-y-2';

                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between bg-white p-3 rounded-md border border-gray-200';

                    const fileInfo = document.createElement('div');
                    fileInfo.className = 'flex items-center space-x-3 truncate';
                    fileInfo.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="truncate">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                        </div>
                    `;

                    fileItem.appendChild(fileInfo);
                    listContainer.appendChild(fileItem);
                }

                fileList.appendChild(listContainer);
            }
        }

        // Set minimum date to today
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tanggal').min = new Date().toISOString().split('T')[0];
        });
    </script>
</x-mhs-layout>
