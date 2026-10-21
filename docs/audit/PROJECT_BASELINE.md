# PROJECT BASELINE

**Tanggal Pemeriksaan:** 21 Oktober 2026  
**Auditor:** Hermes Agent (Software Architect, Senior Engineer, QA Engineer & DevSecOps Reviewer)  
**Root Proyek:** `E:\Projects\sim-main`  
**Status Baseline:** Initialized (Read-Only Baseline Complete)  

---

## 1. Identifikasi Proyek & Tech Stack

- **Nama / Domain Proyek:** Sistem Informasi Manajemen Bimbingan Akademik / Tugas Akhir (SIM Bimbingan - UBSI).
- **Jenis Aplikasi:** Web Monolith (Full-stack Laravel + Blade + Tailwind CSS + Alpine.js).
- **Backend Stack:**
  - PHP: 8.2.12 (ZTS Visual C++ 2019 x64)
  - Framework: Laravel 11 (`laravel/framework: ^11.31`)
  - Package Utama: `laravel/socialite: ^5.21`, `maatwebsite/excel: ^3.1`, `orangehill/iseed: ^3.1`, `laravel/tinker: ^2.9`
  - Package Dev: `phpunit/phpunit: ^11.0.1`, `laravel/pint: ^1.13`, `laravel/sail: ^1.26`, `mockery/mockery: ^1.6`, `fakerphp/faker: ^1.23`
- **Frontend Stack:**
  - Node.js: v26.7.0
  - npm: 11.19.0
  - Bundler: Vite (`vite: ^6.0.11`, `laravel-vite-plugin: ^1.2.0`)
  - CSS / UI: Tailwind CSS (`tailwindcss: ^3.4.17`), PostCSS (`postcss: ^8.5.2`), Autoprefixer (`autoprefixer: ^10.4.20`), `@tailwindcss/vite: ^4.0.6`
  - JavaScript Libraries: Alpine.js (`alpinejs: ^3.14.9`, `@alpinejs/collapse: ^3.14.9`), Chart.js (`chart.js: ^4.5.0`), Axios (`axios: ^1.7.4`)
- **Database Engine:** MySQL (berdasarkan konfigurasi `config/database.php` default mysql, fallback sqlite tersedia).

---

## 2. Struktur Direktori Utama (Max 3 Level)

```
sim-main/
├── app/
│   ├── Exports/ (ApbdesExport.php)
│   ├── Http/
│   │   ├── Controllers/ (Admin, Dosen, Mhs, Auth, Profilebsi, dll.)
│   │   └── Middleware/ (RoleMiddleware.php)
│   ├── Models/ (User, Dosen, Mahasiswa, Bimbingan, Dokumen, KomentarBimbingan, ProgramStudi, TahunAjar)
│   ├── Providers/ (AppServiceProvider.php)
│   └── View/Components/ (Table, Search, Navbar, Input, Modal, Layout, Card, ButtonLink)
├── bootstrap/ (app.php, providers.php, cache/)
├── config/ (app, auth, database, fakultas, session, dll.)
├── database/
│   ├── factories/ (UserFactory.php)
│   ├── migrations/ (13 migration files untuk users, dosen, mahasiswa, bimbingan, dokumen, dll.)
│   └── seeders/ (DatabaseSeeder, DosenSeeder, MahasiswaSeeder, UserSeeder, dll.)
├── public/
│   ├── doc/ (dokumen PDF lampiran bimbingan)
│   ├── img/ (aset gambar profil dan logo)
│   ├── profile/ (subdirektori admin, dosen, mhs)
│   └── index.php, robots.txt, .htaccess
├── resources/
│   ├── css/ (app.css)
│   ├── js/ (app.js, bootstrap.js)
│   └── views/ (auth, admin, dosen, mahasiswa, components, layouts, partials)
├── routes/ (web.php, Auth.php, console.php)
├── storage/ (app, framework, logs)
├── tests/
│   ├── Feature/ (ExampleTest.php)
│   ├── Unit/ (ExampleTest.php)
│   └── TestCase.php
├── composer.json & composer.lock
├── package.json & package-lock.json
├── phpunit.xml
├── PLAYBOOK.md
└── README.md
```

---

## 3. Kondisi Git Baseline

- **Repository Status:** Bukan repository Git (`fatal: not a git repository (or any of the parent directories): .git`).
- **Branch:** N/A.
- **Remote:** N/A.
- **Pre-existing Working Tree State:** Seluruh file saat ini berada di filesystem lokal tanpa tracking Git.
- **Git Safety Rule Sesuai Playbook:** Dilarang melakukan inisialisasi Git (`git init`) otomatis sebelum fase Git readiness dan tanpa otorisasi.

---

## 4. Hasil Baseline Kualitas & Pengujian Awal

| Pemeriksaan | Perintah | Exit Code | Status | Hasil Aktual & Catatan |
|---|---|---|---|---|
| PHP Syntax Check | `find app config routes database -name "*.php" -exec php -l {} +` | 0 | `PASS` | Seluruh file PHP di direktori utama valid sintaksis. |
| Composer Validate | `php "C:/Program Files/composer.phar" validate` | 0 | `PASS` | `./composer.json` berstatus valid. |
| Composer Security Audit | `php "C:/Program Files/composer.phar" audit --locked` | 1 | `FAIL` | Ditemukan 65 advisories keamanan pada 17 package (termasuk Guzzle, Symfony, phpseclib, PHPUnit). |
| NPM Security Audit | `npm audit --json` | 1 | `FAIL` | Ditemukan 22 vulnerabilitas (2 critical, 17 high, 3 moderate) pada package lock frontend. |
| PHPUnit Test Suite | `php artisan test` / `vendor/bin/phpunit` | 255 | `NOT RUN` | Direktori `vendor/` belum terpasang (`composer install` belum dijalankan). |
| Frontend Asset Build | `npm run build` (`vite build`) | 1 | `NOT RUN` / `FAIL` | `node_modules/` belum terpasang (`vite` tidak ditemukan). |
| Database Migration Baseline | `php artisan migrate:status` | 255 | `NOT RUN` | Bergantung pada `vendor/autoload.php` dan koneksi database aktif. |

---

## 5. Sumber Kebenaran yang Ditemukan

1. **Dokumentasi Formal:** Belum ditemukan file `PRD.md`, `SPECIFICATION.md`, atau `ERD.md` bawaan. File `README.md` saat ini masih berupa template bawaan Laravel.
2. **Definisi Perilaku Sistem Aktual:**
   - Database Migrations (`database/migrations/`): 13 file migrasi.
   - Database Seeders (`database/seeders/`): Master data dan data simulasi awal.
   - Routing: `routes/web.php` dan `routes/Auth.php`.
   - Autentikasi & Otorisasi: `RoleMiddleware.php` dengan pembagian role Admin (`1`), Dosen (`2`), Mahasiswa (`3`).
   - Kontroler dan View Blade: `app/Http/Controllers/` dan `resources/views/`.

---

## 6. Daftar Risiko Awal & Kendala Eksekusi

1. **Ketiadaan Vendor & Node Modules:** Tanpa `composer install` dan `npm install`, pengujian dinamis (PHPUnit, artisan, pest) dan build asset (Vite) tidak dapat dijalankan di runtime.
2. **Ketiadaan Dokumen Spesifikasi Resmi:** Seluruh pemahaman aturan bisnis harus direkonstruksi secara hati-hati dari kode sumber dan skema database, dengan status DRAFT yang membutuhkan konfirmasi pemilik proyek.
3. **Audit Kemanan Dependency:** Paket-paket di lockfile memiliki banyak kerentanan CVE yang tercatat pada `composer.lock` dan `package-lock.json`.
4. **Git Repository Belum Diinisialisasi:** Perlu diputuskan bersama pengguna kapan inisialisasi Git dilakukan agar snapshot baseline historis dapat terjaga secara terkontrol.
