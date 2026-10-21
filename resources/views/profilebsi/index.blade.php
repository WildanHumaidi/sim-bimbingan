<x-layout>
    <x-slot:title>Daftar Pengumuman</x-slot:title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1e293b 0%, #173C4F 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .icon-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #173C4F 100%);
        }

        .facility-card {
            background: linear-gradient(135deg, #1e293b 0%, #173C4F 100%);
            transition: transform 0.3s ease;
            min-height: 140px;
        }

        .facility-card:hover {
            transform: scale(1.05);
        }

        .achievement-item {
            position: relative;
            padding-left: 2.5rem;
        }

        .achievement-item::before {
            content: '🏆';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.2rem;
        }

        .faculty-item {
            position: relative;
            padding-left: 2.5rem;
        }

        .faculty-item::before {
            content: '🎓';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.2rem;
        }

        .program-item {
            position: relative;
            padding-left: 2.5rem;
        }

        .program-item::before {
            content: '📚';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.2rem;
        }

        .header-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #173C4F 100%);
        }

        .vision-bg {
            background: linear-gradient(135deg, #1e293b 0%, #173C4F 100%);
        }

        .section-card {
            min-height: 400px;
        }

        .facility-section {
            min-height: 300px;
        }

        @media (max-width: 768px) {
            .section-card {
                min-height: auto;
            }
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Profile Section -->
            <div class="profile-card rounded-3xl shadow-xl mb-8 overflow-hidden">
                <!-- Top gradient line -->
                <div class="h-2 bg-gradient-to-r from-slate-600 via-slate-700 to-slate-800"></div>

                <div class="p-8 text-center">
                    <!-- Logo -->
                    <div class="mb-6">
                        <div class="w-24 h-24 mx-auto mb-4 icon-gradient rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-graduation-cap text-3xl text-white"></i>
                        </div>
                        <h1 class="text-4xl font-bold gradient-text mb-2">Bina Sarana Informatika</h1>
                        <p class="text-slate-600 text-lg">Perguruan Tinggi Unggul di Bidang Teknologi dan Ekonomi Kreatif</p>
                    </div>

                    <!-- Vision Box -->
                    <div class="vision-bg text-white p-6 rounded-2xl">
                        <div class="flex items-center justify-center mb-2">
                            <i class="fas fa-eye mr-3 text-xl"></i>
                            <span class="font-semibold text-lg">Visi 2033</span>
                        </div>
                        <p class="text-slate-100">Menjadi universitas unggul di bidang ekonomi kreatif yang menghasilkan lulusan berkualitas dan berdaya saing global</p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid lg:grid-cols-3 gap-8 mb-8">
                <!-- Fakultas Card -->
                <div class="profile-card rounded-2xl shadow-lg overflow-hidden card-hover section-card">
                    <div class="p-6 h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 icon-gradient rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-university text-white text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Fakultas</h3>
                        </div>
                        <div class="space-y-4 flex-1">
                            <div class="faculty-item">
                                <h4 class="font-semibold text-slate-800">Fakultas Teknik & Informatika</h4>
                                <p class="text-sm text-slate-600">Program studi berbasis teknologi dan rekayasa</p>
                            </div>
                            <div class="faculty-item">
                                <h4 class="font-semibold text-slate-800">Fakultas Ekonomi & Bisnis</h4>
                                <p class="text-sm text-slate-600">Program studi ekonomi dan manajemen bisnis</p>
                            </div>
                            <div class="faculty-item">
                                <h4 class="font-semibold text-slate-800">Fakultas Komunikasi & Bahasa</h4>
                                <p class="text-sm text-slate-600">Program studi komunikasi dan linguistik</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Pendidikan Card -->
                <div class="profile-card rounded-2xl shadow-lg overflow-hidden card-hover section-card">
                    <div class="p-6 h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 icon-gradient rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-book-open text-white text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Program Pendidikan</h3>
                        </div>
                        <div class="space-y-4 flex-1">
                            <div class="program-item">
                                <h4 class="font-semibold text-slate-800">Program Diploma 3 (D3)</h4>
                                <p class="text-sm text-slate-600">Program vokasi 3 tahun dengan fokus praktis</p>
                            </div>
                            <div class="program-item">
                                <h4 class="font-semibold text-slate-800">Program Sarjana (S1)</h4>
                                <p class="text-sm text-slate-600">Program akademik 4 tahun terakreditasi</p>
                            </div>
                            <div class="program-item">
                                <h4 class="font-semibold text-slate-800">Program Magister (S2)</h4>
                                <p class="text-sm text-slate-600">Sedang dalam tahap persiapan pembukaan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prestasi & Akreditasi Card -->
                <div class="profile-card rounded-2xl shadow-lg overflow-hidden card-hover section-card">
                    <div class="p-6 h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 icon-gradient rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-trophy text-white text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Prestasi & Akreditasi</h3>
                        </div>
                        <div class="space-y-4 flex-1">
                            <div class="achievement-item">
                                <h4 class="font-semibold text-slate-800">Akreditasi Peringkat Unggul</h4>
                                <p class="text-sm text-slate-600">Diakui oleh BAN-PT dengan peringkat tertinggi</p>
                            </div>
                            <div class="achievement-item">
                                <h4 class="font-semibold text-slate-800">Silver Medal Winner</h4>
                                <p class="text-sm text-slate-600">Media Sosial Terbaik Anugerah Diktiristek 2023</p>
                            </div>
                            <div class="achievement-item">
                                <h4 class="font-semibold text-slate-800">Kerjasama Industri</h4>
                                <p class="text-sm text-slate-600">Partnership dengan berbagai perusahaan ternama</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fasilitas Section -->
            <div class="profile-card rounded-2xl shadow-lg overflow-hidden mb-8 facility-section">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 icon-gradient rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800">Fasilitas Unggulan</h3>
                    </div>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="facility-card text-white p-4 rounded-xl text-center flex flex-col justify-center">
                            <i class="fas fa-briefcase text-2xl mb-3"></i>
                            <h4 class="font-semibold mb-2">BSI Career Center</h4>
                            <p class="text-xs opacity-90">Pusat pengembangan karier mahasiswa</p>
                        </div>
                        <div class="facility-card text-white p-4 rounded-xl text-center flex flex-col justify-center">
                            <i class="fas fa-lightbulb text-2xl mb-3"></i>
                            <h4 class="font-semibold mb-2">BSI Entrepreneur Center</h4>
                            <p class="text-xs opacity-90">Inkubator bisnis dan kewirausahaan</p>
                        </div>
                        <div class="facility-card text-white p-4 rounded-xl text-center flex flex-col justify-center">
                            <i class="fas fa-laptop text-2xl mb-3"></i>
                            <h4 class="font-semibold mb-2">Laboratorium IT</h4>
                            <p class="text-xs opacity-90">Lab komputer dengan teknologi terkini</p>
                        </div>
                        <div class="facility-card text-white p-4 rounded-xl text-center flex flex-col justify-center">
                            <i class="fas fa-book text-2xl mb-3"></i>
                            <h4 class="font-semibold mb-2">Perpustakaan Digital</h4>
                            <p class="text-xs opacity-90">Koleksi buku dan jurnal digital lengkap</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Section -->
            <div class="profile-card rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-slate-800 mb-6 text-center">Statistik BSI</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-r from-slate-600 to-slate-700 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold gradient-text">50,000+</div>
                            <div class="text-sm text-slate-600">Total Alumni</div>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-r from-slate-500 to-slate-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-graduate text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold gradient-text">25,000+</div>
                            <div class="text-sm text-slate-600">Mahasiswa Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-r from-slate-700 to-slate-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold gradient-text">500+</div>
                            <div class="text-sm text-slate-600">Dosen & Staff</div>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-r from-slate-600 to-slate-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold gradient-text">50+</div>
                            <div class="text-sm text-slate-600">Kampus & PSDKU</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lokasi Kampus Section -->
            <div class="profile-card rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 icon-gradient rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800">Lokasi Kampus</h3>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-lg text-slate-800 mb-3">Kampus Utama Jabodetabek</h4>
                            <div class="space-y-2 text-sm text-slate-600">
                                <div class="flex items-center">
                                    <i class="fas fa-building text-slate-500 mr-2"></i>
                                    Jakarta Pusat, Jakarta Timur, Jakarta Selatan
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-building text-slate-500 mr-2"></i>
                                    Bogor, Depok, Tangerang, Bekasi
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-building text-slate-500 mr-2"></i>
                                    Pontianak, Tegal, Sukabumi
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-slate-800 mb-3">PSDKU (Program Studi di Luar Kampus Utama)</h4>
                            <div class="space-y-2 text-sm text-slate-600">
                                <div class="flex items-center">
                                    <i class="fas fa-graduation-cap text-slate-500 mr-2"></i>
                                    Tersebar di berbagai provinsi Indonesia
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-graduation-cap text-slate-500 mr-2"></i>
                                    Mempermudah akses pendidikan tinggi
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-graduation-cap text-slate-500 mr-2"></i>
                                    Standar kualitas yang sama dengan kampus utama
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alumni Network Section -->
            <div class="profile-card rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-slate-600 to-slate-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-network-wired text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">IKAUBSI - Jaringan Alumni</h3>
                        <p class="text-slate-600 mb-4">Organisasi alumni BSI yang menjalin kerjasama dengan industri dan memberikan dukungan berkelanjutan bagi para alumni</p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <div class="bg-slate-100 text-slate-800 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-handshake mr-2"></i>
                                Kerjasama Industri
                            </div>
                            <div class="bg-slate-100 text-slate-800 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-users mr-2"></i>
                                Support Network
                            </div>
                            <div class="bg-slate-100 text-slate-800 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-rocket mr-2"></i>
                                Career Development
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
