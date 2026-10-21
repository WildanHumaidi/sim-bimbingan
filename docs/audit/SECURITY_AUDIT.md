# SECURITY AUDIT REPORT

**Proyek:** Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan - UBSI)  
**Tanggal Audit:** 21 Oktober 2026  
**Auditor:** Hermes Agent (DevSecOps Reviewer)  
**Ruang Lingkup:** Kode sumber (`app/`, `config/`, `routes/`, `resources/`, `database/`), template konfigurasi (`.env.example`), dependency lockfiles (`composer.lock`, `package-lock.json`), dan permission/storage.  
**Klasifikasi:** CONFIDENTIAL / AUDIT EVIDENCE  

---

## 1. Ringkasan Eksekutif

Audit keamanan menyeluruh dilakukan terhadap kode aplikasi, konfigurasi, dan dependensi. Proyek ini **TIDAK DAPAT DIKLASIFIKASIKAN SEBAGAI SECURE** pada kondisi saat ini. Ditemukan paparan kredensial database live dan APP_KEY aktif pada template `.env.example`, kerentanan Stored Cross-Site Scripting (XSS) pada modul bimbingan admin, penyimpanan file upload di direktori publik tanpa autentikasi, ketiadaan rate-limiting pada endpoint autentikasi, inkonsistensi tipe data otorisasi RBAC, serta puluhan kerentanan CVE pada dependensi pihak ketiga.

---

## 2. Tabel Ringkasan Temuan Keamanan

| ID | Kategori | Severity | Status | Lokasi Utama | Ringkasan Temuan |
|---|---|---|---|---|---|
| SEC-001 | Secret Exposure | `P0 Critical` | `Confirmed` | `.env.example:3,24-28` | Kredensial aktif Railway MySQL dan APP_KEY tertera dalam template publik. |
| SEC-002 | Injection / XSS | `P1 High` | `Confirmed` | `resources/views/admin/bimbingan/edit.blade.php:9,90` | Stored XSS via output unescaped `{!! ... !!}` pada JS dan HTML editor. |
| SEC-003 | Storage & Access Control | `P1 High` | `Confirmed` | `app/Http/Controllers/Mhs/MhsBimbinganController.php:110-115` | File dokumen diunggah ke `public/doc` (0777) dapat diakses publik tanpa login. |
| SEC-004 | Authentication & Brute Force | `P2 Medium` | `Confirmed` | `routes/Auth.php:10,14,16` | Tidak ada rate limiting / throttling pada rute login dan registrasi. |
| SEC-005 | Authorization / RBAC | `P2 Medium` | `Confirmed` | `app/Http/Middleware/RoleMiddleware.php:31`, `User.php` | Perbandingan tipe ketat `!==` tanpa integer cast pada model berisiko gagal otorisasi. |
| SEC-006 | Info Disclosure | `P2 Medium` | `Confirmed` | `app/Http/Controllers/Admin/UserController.php:94,148,195` | Raw exception message ($e->getMessage()) dibocorkan langsung ke user interface. |
| SEC-007 | Broken Route / DoS | `P2 Medium` | `Confirmed` | `routes/web.php:133`, `DosenBimbinganController.php` | Rute `dosen.bimbingan.dokumen.delete` memanggil method `deleteDokumen` yang tidak ada. |
| SEC-008 | Data Integrity / Atomicity | `P2 Medium` | `Confirmed` | `AuthController.php:95-108,126-138`, `UserController.php` | Registrasi multi-tabel tanpa `DB::transaction()`; orphaned user timbul saat child insert gagal. |
| SEC-009 | Broken Socialite & Weak Password | `P2 Medium` | `Confirmed` | `app/Http/Controllers/Auth/SocialiteController.php:30` | Password default hardcoded `'123'`, kolom skema tidak valid, dan namespace salah. |
| SEC-010 | Dependency Vulnerabilities | `P2 Medium` | `Confirmed` | `composer.lock`, `package-lock.json` | 65 advisories CVE PHP (Guzzle, Symfony, phpseclib) dan 22 vulnerabilitas npm. |

---

## 3. Rincian Temuan Keamanan

### SEC-001: Kredensial Database Live dan APP_KEY Tertera pada Template `.env.example`
- **Severity:** `P0 Critical`
- **Confidence:** `Confirmed`
- **Lokasi:** `.env.example` baris 3, 6, 24-28
- **Bukti (Disamarkan):**
  ```env
  APP_KEY=base64:kUoZnhQbQcylKJAn8ge9cXiim7+bUE+EL7[REDACTED]=
  APP_URL=https://kelompok32.up.railway.app
  DB_HOST=metro.proxy.rlwy.net
  DB_PORT=27293
  DB_DATABASE=railway
  DB_USERNAME=root
  DB_PASSWORD=[REDACTED_RAILWAY_LIVE_SECRET]
  ```
- **Dampak Teknis & Bisnis:** Siapa pun yang mendapatkan file ini (atau jika dipublikasikan ke Git/GitHub) dapat mengakses langsung database cloud produksi di Railway, membaca seluruh data pengguna, menghapus database, atau menyalahgunakan hak akses root.
- **Rekomendasi:**
  1. Segera lakukan rotasi kredensial database di Railway console melalui pemilik sistem.
  2. Bersihkan nilai sensitif dari `.env.example` menjadi placeholder standar: `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_DATABASE=sim_bimbingan`, `DB_USERNAME=root`, `DB_PASSWORD=`, `APP_KEY=`.
  3. Lakukan rotasi APP_KEY lokal dengan `php artisan key:generate`.

---

### SEC-002: Stored Cross-Site Scripting (XSS) pada Formulir Edit Bimbingan Admin
- **Severity:** `P1 High`
- **Confidence:** `Confirmed`
- **Lokasi:** `resources/views/admin/bimbingan/edit.blade.php` baris 9 dan baris 90
- **Bukti:**
  - Baris 9 (Konteks JavaScript/Alpine):
    ```blade
    topik: '{!! old('topik', $bimbingan->topik) !!}',
    ```
  - Baris 90 (Konteks HTML inner element):
    ```blade
    <div id="editor" class="min-h-[250px] border border-gray-300 rounded-lg">{!! old('topik', $bimbingan->topik) !!}</div>
    ```
- **Titik Awal Penyimpangan (First Divergence):** Penggunaan tag `{!! ... !!}` tanpa HTML sanitization atau encoding JSON pada variabel yang dikendalikan pengguna (`$bimbingan->topik`).
- **Dampak Teknis & Bisnis:** Mahasiswa dapat menyisipkan payload JavaScript jahat pada kolom `topik`. Saat Administrator membuka halaman edit bimbingan, skrip penyerang akan dieksekusi dalam sesi browser Admin, memungkinkan pencurian session cookie, CSRF action, atau pengambilalihan akun admin.
- **Rekomendasi:**
  1. Untuk konteks JS: Gunakan `@js(old('topik', $bimbingan->topik))` atau `{{ json_encode(old('topik', $bimbingan->topik)) }}`.
  2. Untuk konteks HTML editor: Gunakan escape standar `{{ old('topik', $bimbingan->topik) }}` atau sanitasi menggunakan HTMLPurifier jika HTML diizinkan.

---

### SEC-003: Penyimpanan Dokumen Upload pada Direktori Publik Tanpa Otorisasi
- **Severity:** `P1 High`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Http/Controllers/Mhs/MhsBimbinganController.php` baris 110-115, 187-192
- **Bukti:**
  ```php
  if (!file_exists(public_path('doc'))) {
      mkdir(public_path('doc'), 0777, true);
  }
  $fileName = time().'_'.$file->getClientOriginalName();
  $file->move(public_path('doc'), $fileName);
  ```
- **Dampak Teknis & Bisnis:**
  - Dokumen bimbingan mahasiswa (draft skripsi, proposal, artikel) dapat diunduh langsung oleh siapa saja di internet tanpa autentikasi melalui URL `https://domain.com/doc/<filename>`.
  - Direktori dibuat dengan mode `0777` (world-writable).
  - Penggunaan `$file->getClientOriginalName()` tanpa sanitasi nama file rentan terhadap path traversal / nama file anomali.
- **Rekomendasi:**
  1. Simpan dokumen sensitif di disk privat (`storage/app/private` atau disk `local`) dan buat route streaming download terproteksi (`Route::get('/bimbingan/dokumen/{id}/download')`) yang memverifikasi bahwa pengunduh adalah pemilik bimbingan, dosen pembimbing terkait, atau admin.
  2. Gunakan nama file acak yang aman (`Str::uuid()` atau hash).

---

### SEC-004: Tidak Ada Rate Limiting pada Rute Autentikasi dan Registrasi
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `routes/Auth.php` baris 9-16
- **Bukti:**
  ```php
  Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
  Route::post('/register/mahasiswa', [AuthController::class, 'registerMahasiswa']);
  Route::post('/register/dosen', [AuthController::class, 'registerDosen']);
  ```
- **Dampak Teknis & Bisnis:** Penyerang dapat melakukan brute-force attack terhadap kata sandi akun pengguna tanpa batas percobaan, atau melakukan mass spam registration yang membebani database.
- **Rekomendasi:** Terapkan middleware `throttle:login` atau `throttle:5,1` pada rute login dan `throttle:10,1` pada rute registrasi.

---

### SEC-005: Inkonsistensi Otorisasi Tipe Ketat pada RoleMiddleware
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Http/Middleware/RoleMiddleware.php` baris 26-31, `app/Models/User.php`
- **Bukti:**
  ```php
  $currentRole = $user->role;
  $requiredRole = (int)$requiredRole;
  if ($currentRole !== $requiredRole) { ... }
  ```
- **Dampak Teknis & Bisnis:** Pada model `User.php`, property `$casts` tidak mendefinisikan `'role' => 'integer'`. Pada driver database tertentu yang mengembalikan nilai numeric column sebagai tipe data `string`, kondisi `'1' !== 1` bernilai `true`, mengakibatkan pengguna valid terlempar ke loop redirect atau gagal otorisasi.
- **Rekomendasi:** Tambahkan `$casts = ['role' => 'integer'];` pada `User.php` dan pastikan konversi `(int)$currentRole !== $requiredRole` di middleware.

---

### SEC-006: Pembocoran Detail Eksepsi Database ke Antarmuka Pengguna
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Http/Controllers/Admin/UserController.php` baris 94, 148, 195
- **Bukti:**
  ```php
  return redirect()->back()
      ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
      ->withInput();
  ```
- **Dampak Teknis & Bisnis:** Jika terjadi kesalahan SQL atau foreign key violation, pesan sistem internal (termasuk nama tabel, kolom, dan struktur kueri) akan dicetak langsung ke antarmuka pengguna, memudahkan reconnaissance oleh penyerang.
- **Rekomendasi:** Catat detail teknis ke log internal (`Log::error($e)`) dan tampilkan pesan kesalahan generik yang aman ke antarmuka pengguna (`'Terjadi kesalahan saat memproses data. Silakan coba lagi.'`).

---

### SEC-007: Broken Route Handler `deleteDokumen` pada Rute Dosen
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `routes/web.php` baris 133, `app/Http/Controllers/Dosen/DosenBimbinganController.php`
- **Bukti:**
  - Pada `routes/web.php`:
    ```php
    Route::delete('/bimbingan/dokumen/{id}', [DosenBimbinganController::class, 'deleteDokumen'])->name('dosen.bimbingan.dokumen.delete');
    ```
  - Pada `DosenBimbinganController.php`: Method `deleteDokumen` tidak dideklarasikan.
- **Dampak Teknis & Bisnis:** Pemanggilan endpoint menghasilkan HTTP 500 `BadMethodCallException`, merusak fungsionalitas penghapusan lampiran bimbingan oleh dosen.
- **Rekomendasi:** Implementasikan method `deleteDokumen` pada `DosenBimbinganController` dengan otorisasi NIDN dosen yang valid, atau hapus definisi rute jika fitur tidak disediakan.

---

### SEC-008: Registrasi Multi-Tabel Tanpa Transaksi Database (`DB::transaction`)
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Http/Controllers/Auth/AuthController.php` baris 95-108 & 126-138, `Admin/UserController.php`
- **Bukti:**
  ```php
  $user = User::create([...]);
  Mahasiswa::create([...]); // jika gagal, $user tetap ada
  ```
- **Dampak Teknis & Bisnis:** Jika query kedua gagal (misal validasi kolom database, constraint, atau nilai fakultas tidak lengkap pada dosen), data user telah terlanjur tersimpan di tabel `users` tanpa relasi profil mahasiswa/dosen. Pengguna tidak bisa login (karena relasi null) dan tidak bisa mendaftar ulang karena email/username sudah berstatus unik di tabel users.
- **Rekomendasi:** Bungkus operasi pembuatan user dan profil terkait di dalam `DB::transaction(function () use (...) { ... });`.

---

### SEC-009: Broken Socialite Controller dengan Hardcoded Password dan Nama Kolom Fiktif
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Http/Controllers/Auth/SocialiteController.php` baris 3, 22-33
- **Bukti:**
  ```php
  // Namespace salah: file di Auth/ tetapi namespace App\Http\Controllers
  'password' => Hash::make('123'), // Password statis lemah
  'google_id' => $socialUser->id,  // Kolom tidak ada di tabel users
  'name' => $socialUser->name,      // Kolom tidak ada di tabel users
  ```
- **Dampak Teknis & Bisnis:** Fitur login Google crash dengan SQL exception karena kolom tidak ada di database, serta menetapkan password statis `'123'` yang sangat tidak aman.
- **Rekomendasi:** Perbaiki arsitektur controller Google Socialite atau nonaktifkan rute jika Google OAuth belum dikonfigurasi dan belum didukung skema database.

---

### SEC-010: Kerentanan Keamanan pada Dependensi Pihak Ketiga (Supply Chain)
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `composer.lock`, `package-lock.json`
- **Bukti:**
  - `composer audit --locked`: 65 advisories pada 17 package (Guzzle CVE-2026-69246, Symfony CVE-2026-45067, phpseclib CVE-2026-32935, PHPUnit CVE-2026-24765).
  - `npm audit`: 22 kerentanan (2 Critical pada form-data & shell-quote; 17 High pada axios, braces, vite, lodash, glob, nanoid).
- **Dampak Teknis & Bisnis:** Risiko serangan rantai pasok jika package digunakan untuk memproses input tak tepercaya atau di-expose ke jaringan eksternal.
- **Rekomendasi:** Lakukan pembaruan terencana pada dependensi yang terdampak setelah pengujian regresi.

---

## 4. Kesimpulan Gerbang Keamanan (Security Gate)

Sesuai ketentuan FASE 1 Playbook:
**Status Gate:** `FAIL / REMEDIATION REQUIRED`  
Proyek tidak dapat dinyatakan aman untuk rilis sebelum temuan P0 (paparan secret Railway) dan P1 (Stored XSS serta insecure document storage) diperbaiki dan diverifikasi.
