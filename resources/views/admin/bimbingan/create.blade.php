<x-admin-layout>
    <x-slot:title>Tambah Bimbingan</x-slot:title>

    <div class="p-6" x-data="{
        showPassword: false,
        selectedMahasiswa: '',
        selectedDosen: '',
        tanggal: '',
        topik: '',
        catatan: '',
        statusValidasi: 'Pending',
        files: []
    }">

        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-8 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Bimbingan Baru</h1>
                <p class="text-md text-gray-600 mt-2">Lengkapi form di bawah untuk menambahkan data bimbingan</p>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                        </div>
                        <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bimbingan.store') }}" method="POST" enctype="multipart/form-data" id="bimbinganForm">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Mahasiswa --}}
                        <div>
                            <label for="nim" class="block text-md font-medium text-gray-700 mb-3">Mahasiswa <span class="text-red-500">*</span></label>
                            <select name="nim" id="nim" x-model="selectedMahasiswa" required
                                class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Pilih Mahasiswa</option>
                                @foreach ($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id_nim }}">{{ $mhs->nama }} - {{ $mhs->id_nim }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dosen --}}
                        <div>
                            <label for="nidn" class="block text-md font-medium text-gray-700 mb-3">Dosen Pembimbing <span class="text-red-500">*</span></label>
                            <select name="nidn" id="nidn" x-model="selectedDosen" required
                                class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Pilih Dosen</option>
                                @foreach ($dosen as $dsn)
                                    <option value="{{ $dsn->id_nidn }}">{{ $dsn->nama }} - {{ $dsn->id_nidn }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label for="tanggal" class="block text-md font-medium text-gray-700 mb-3">Tanggal Bimbingan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" x-model="tanggal" required
                                class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        {{-- Status Validasi --}}
                        <div>
                            <label for="status_validasi" class="block text-md font-medium text-gray-700 mb-3">Status Validasi <span class="text-red-500">*</span></label>
                            <select name="status_validasi" id="status_validasi" x-model="statusValidasi" required
                                class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="Pending">Pending</option>
                                <option value="Valid">Valid</option>
                                <option value="Invalid">Invalid</option>
                            </select>
                        </div>
                    </div>

                    {{-- Topik Bimbingan --}}
                    <div class="mt-8">
                        <label for="topik" class="block text-md font-medium text-gray-700 mb-3">Topik Bimbingan <span class="text-red-500">*</span></label>
                        <textarea name="topik" id="topik" x-model="topik" class="hidden" required></textarea>
                        <div id="editor" class="min-h-[250px] border border-gray-300 rounded-lg"></div>
                        <p class="text-sm text-gray-500 mt-2">Gunakan editor di atas untuk menulis topik bimbingan dengan lengkap</p>
                    </div>

                    {{-- Catatan --}}
                    <div class="mt-8">
                        <label for="catatan" class="block text-md font-medium text-gray-700 mb-3">Catatan Tambahan</label>
                        <textarea name="catatan" id="catatan" rows="5" x-model="catatan"
                            placeholder="Masukkan catatan tambahan jika diperlukan..."
                            class="w-full px-4 py-3 text-md border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
                    </div>

                    {{-- Upload Dokumen --}}
                    <div class="mt-8">
                        <label for="dokumen" class="block text-md font-medium text-gray-700 mb-3">Upload Dokumen Pendukung</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-gray-400 transition-colors">
                            <input type="file" name="dokumen[]" id="dokumen" multiple accept=".pdf,.doc,.docx"
                                class="hidden" @change="files = Array.from($event.target.files)">
                            <label for="dokumen" class="cursor-pointer">
                                <div class="space-y-3">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <div class="text-md text-gray-600">
                                        <span class="font-medium text-blue-600 hover:text-blue-500">Klik untuk upload</span> atau drag and drop
                                    </div>
                                    <p class="text-sm text-gray-500">PDF, DOC, DOCX (Maksimal 2MB per file)</p>
                                </div>
                            </label>
                        </div>

                        {{-- File List --}}
                        <div x-show="files.length > 0" class="mt-4 space-y-3">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-md text-gray-700" x-text="file.name"></span>
                                        <span class="text-sm text-gray-500" x-text="'(' + (file.size / 1024 / 1024).toFixed(2) + ' MB)'"></span>
                                    </div>
                                    <button type="button" @click="files.splice(index, 1); updateFileInput()"
                                        class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4 pt-8 border-t border-gray-200">
                        <a href="{{ route('bimbingan.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors text-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Bimbingan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- CKEditor CDN --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let editor;

                ClassicEditor
                    .create(document.querySelector('#editor'), {
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                                'blockQuote', 'insertTable', 'undo', 'redo'
                            ]
                        },
                        placeholder: 'Tuliskan topik bimbingan secara detail...',
                    })
                    .then(instance => {
                        editor = instance;

                        editor.model.document.on('change:data', () => {
                            document.getElementById('topik').value = editor.getData();
                        });

                        document.getElementById('topik').value = editor.getData();
                    })
                    .catch(error => {
                        console.error(error);
                    });

                window.updateFileInput = function() {
                    const fileInput = document.getElementById('dokumen');
                    const dataTransfer = new DataTransfer();

                    files.forEach(file => {
                        dataTransfer.items.add(file);
                    });

                    fileInput.files = dataTransfer.files;
                };

                document.getElementById('bimbinganForm').addEventListener('submit', function() {
                    if (editor) {
                        document.getElementById('topik').value = editor.getData();
                    }
                });
            });
        </script>

    </div>
</x-admin-layout>
