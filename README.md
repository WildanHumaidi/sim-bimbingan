# SIM Bimbingan — Sistem Informasi Manajemen Bimbingan Akademik & Tugas Akhir

Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan) adalah platform web berbasis Laravel 11 yang dirancang untuk mengelola, mencatat, dan memonitor alur bimbingan skripsi, proposal, dan tugas akhir mahasiswa di lingkungan perguruan tinggi (Universitas BSI).

Platform ini mendukung tiga peran pengguna utama: **Administrator**, **Dosen Pembimbing**, dan **Mahasiswa**, dengan alur kerja terstruktur mulai dari pengajuan topik, telaah draf dokumen, validasi sesi bimbingan, hingga diskusi interaktif.

---

## Fitur Utama

### 1. Mahasiswa
- **Registrasi & Autentikasi Mandiri:** Pendaftaran akun mahasiswa menggunakan NIM, nama, prodi, dan tahun angkatan.
- **Pengajuan Sesi Bimbingan:** Mengajukan bimbingan dengan memilih Dosen Pembimbing, tanggal, topik bimbingan, catatan, serta mengunggah draf berkas (PDF/DOC).
- **Dashboard Progres Bimbingan:** Melihat ringkasan sesi yang berstatus `pending`, `valid`, dan `invalid`, serta grafik perkembangan bulanan.
- **Utas Diskusi Bimbingan:** Berkomunikasi secara interaktif melalui kolom komentar pada setiap sesi bimbingan.

### 2. Dosen Pembimbing
- **Dashboard Monitoring:** Memantau bimbingan masuk, notifikasi bimbingan baru dalam 24 jam terakhir, serta statistik bimbingan per bulan.
- **Validasi Dokumen:** Mengunduh dan meninjau draf mahasiswa, memberikan feedback review, mengunggah revisi, dan menetapkan status validasi (`valid`, `invalid`, `pending`).
- **Tandai Status Baca:** Menandai bimbingan yang telah ditinjau baik secara individual maupun massal.
- **Manajemen Komentar:** Memberikan bimbingan terarah dan menghapus feedback dosen jika diperlukan.

### 3. Administrator
- **Manajemen Master Data:** Pengelolaan data Program Studi per Fakultas dan Tahun Ajaran.
- **Manajemen Akun Pengguna:** Pengelolaan akun Admin, Dosen, dan Mahasiswa (pembuatan, pembaruan, dan reset).
- **Monitoring Seluruh Bimbingan:** Pemantauan menyeluruh terhadap seluruh aktivitas bimbingan pada sistem.

---

## Tech Stack

- **Backend Framework:** Laravel 11 (`laravel/framework: ^11.31`)
- **Bahasa Pemrograman:** PHP >= 8.2
- **Frontend Stack:** Tailwind CSS 3.4, Alpine.js 3.14, Chart.js 4.5
- **Build Tool:** Vite 6
- **Database:** MySQL 8.x (dengan dukungan pengujian lokal SQLite in-memory)
- **Autentikasi & Otorisasi:** Laravel Auth dengan custom `RoleMiddleware`

---

## Struktur Direktori

```
sim-main/
├── app/
│   ├── Http/
│   │   ├── Controllers/ (Admin, Dosen, Mhs, Auth)
│   │   └── Middleware/ (RoleMiddleware.php)
│   ├── Models/ (User, Dosen, Mahasiswa, Bimbingan, Dokumen, KomentarBimbingan, ...)
│   └── Providers/
├── config/ (app, auth, database, fakultas, session, filesystems)
├── database/
│   ├── factories/ (UserFactory.php)
│   ├── migrations/ (13 file migrasi skema tabel)
│   └── seeders/ (DatabaseSeeder dan master seeders)
├── docs/ (Dokumentasi lengkap proyek)
│   ├── audit/ (PROJECT_BASELINE.md, SECURITY_AUDIT.md, DEEP_BUG_AUDIT.md, ...)
│   ├── PRD.md (Product Requirements Document)
│   ├── ERD.md (Entity Relationship Diagram & Data Dictionary)
│   ├── ARCHITECTURE.md (Arsitektur Sistem & Alur Kerja)
│   ├── SPECIFICATION.md (Spesifikasi Endpoint & Kontrak)
│   └── SETUP.md (Panduan Instalasi & Konfigurasi)
├── public/ (Aset publik, direktori upload dokumen & avatar)
├── resources/
│   ├── css/ & js/
│   └── views/ (Blade views untuk Admin, Dosen, Mhs, Auth, Layouts)
├── routes/ (web.php, auth.php, console.php)
├── storage/
└── tests/ (Feature dan Unit test suite)
```

---

## Panduan Instalasi Cepat

### Prasyarat
- PHP >= 8.2 (ekstensi `pdo_mysql`, `mbstring`, `gd`, `openssl`)
- Composer >= 2.x
- Node.js >= 20.x & npm >= 10.x
- MySQL Server

### Langkah-langkah
```bash
# 1. Salin file konfigurasi environment
cp .env.example .env

# 2. Pasang dependensi PHP dan Node.js
composer install
npm install

# 3. Generate application key
php artisan key:generate

# 4. Konfigurasi kredensial database di .env, lalu jalankan migrasi & seeder
php artisan migrate --seed

# 5. Hubungkan penyimpanan storage publik
php artisan storage:link

# 6. Kompilasi aset frontend
npm run build

# 7. Jalankan server lokal
php artisan serve
```

Aplikasi dapat diakses melalui peramban web pada alamat `http://localhost:8000`.

---

## Pengujian Otomatis

Proyek ini dilengkapi dengan automated test suite menggunakan SQLite in-memory:
```bash
php artisan test
```

---

## Dokumentasi Teknis Terkait

Dokumentasi detail mengenai desain sistem, arsitektur, basis data, dan audit keamanan tersedia di folder `docs/`:
- [Product Requirements Document (PRD)](docs/PRD.md)
- [Entity Relationship Diagram & Kamus Data](docs/ERD.md)
- [Arsitektur Sistem](docs/ARCHITECTURE.md)
- [Spesifikasi Rute & Endpoint](docs/SPECIFICATION.md)
- [Panduan Setup & Instalasi](docs/SETUP.md)
- [Laporan Audit Keamanan](docs/audit/SECURITY_AUDIT.md)
- [Laporan Audit Bug Mendalam](docs/audit/DEEP_BUG_AUDIT.md)
- [Daftar Risiko (Risk Register)](docs/audit/RISK_REGISTER.md)
- [Rencana Remediasi](docs/audit/REMEDIATION_PLAN.md)

---

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
