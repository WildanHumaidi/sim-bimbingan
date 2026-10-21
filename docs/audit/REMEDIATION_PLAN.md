# REMEDIATION PLAN & CHANGE CONTROL

**Proyek:** Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan - UBSI)  
**Tanggal:** 21 Oktober 2026  
**Auditor:** Hermes Agent (Software Architect & Senior Engineer)  
**Status Dokumen:** READY FOR EXECUTION  

---

## 1. Strategi Remediasi Terkendali

Sesuai FASE 3 `PLAYBOOK.md`, seluruh tindakan perbaikan dilakukan secara bertahap, minimal, terarah pada akar masalah, dan tidak melakukan perombakan arsitektural spekulatif. Perbaikan diprioritaskan dari **P0 (Kritis)**, **P1 (Tinggi)**, disusul **P2 (Sedang)**, sedangkan file sisa template (P3) diisolasi dan menunggu keputusan pemilik proyek.

---

## 2. Paket Kerja Perbaikan (Work Packages)

### WP-01: Redaksi Kredensial Database Live & Secret pada `.env.example` [P0]
- **Target File:** `.env.example`
- **Tujuan:** Menghilangkan paparan kredensial produksi Railway dan APP_KEY aktif agar aman untuk publikasi repository.
- **Perubahan Rinci:**
  - Ganti `APP_KEY` dengan string kosong `APP_KEY=`.
  - Ganti `DB_HOST=metro.proxy.rlwy.net` menjadi `DB_HOST=127.0.0.1`.
  - Ganti `DB_PORT=27293` menjadi `DB_PORT=3306`.
  - Ganti `DB_DATABASE=railway` menjadi `DB_DATABASE=sim_bimbingan`.
  - Ganti `DB_USERNAME=root` dan `DB_PASSWORD=cExB...` menjadi nilai kosong/default lokal.
  - Perbaiki `GOOGLE_REDIRECT_URL` menjadi `GOOGLE_REDIRECT_URI` agar sinkron dengan `config/services.php`.
- **Kriteria Penerimaan:** Tidak ada kredensial live atau secret aktif yang tersisa di `.env.example`.
- **Risiko & Rollback:** Nol. Dapat di-revert seketika jika konfigurasi lokal membutuhkan penyesuaian.

---

### WP-02: Remediasi Stored XSS pada Formulir Edit Bimbingan [P1]
- **Target File:** `resources/views/admin/bimbingan/edit.blade.php`
- **Tujuan:** Menutup celah Stored Cross-Site Scripting pada input topik bimbingan.
- **Perubahan Rinci:**
  - Ubah baris 9 dari:
    ```blade
    topik: '{!! old('topik', $bimbingan->topik) !!}',
    ```
    menjadi:
    ```blade
    topik: @js(old('topik', $bimbingan->topik)),
    ```
  - Ubah baris 90 dari unescaped `{!! ... !!}` menjadi escaped `{{ old('topik', $bimbingan->topik) }}`.
- **Kriteria Penerimaan:** Payload string seperti `<script>alert(1)</script>` atau kutip `'` tidak mengeksekusi kode berbahaya pada browser admin.
- **Risiko & Rollback:** Tampilan teks topik bimbingan tetap utuh di CKEditor tanpa risiko eksekusi skrip jahat.

---

### WP-03: Standardisasi Status Validasi Bimbingan (Casing Mismatch) [P1]
- **Target File:**
  - `app/Models/Bimbingan.php`
  - `app/Http/Controllers/Mhs/MhsBimbinganController.php`
  - `app/Http/Controllers/Dosen/DosenBimbinganController.php`
  - `app/Http/Controllers/Admin/BimbinganController.php`
  - `app/Http/Controllers/Dosen/DashboardDosenController.php`
  - `app/Http/Controllers/Mhs/DashboardMhsController.php`
- **Tujuan:** Menyeragamkan status bimbingan ke lowercase (`pending`, `valid`, `invalid`) sesuai nilai ENUM skema database.
- **Perubahan Rinci:**
  - Tambahkan class constants kanonikal pada `Bimbingan.php`:
    ```php
    const STATUS_PENDING = 'pending';
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    ```
  - Perbarui scope di `Bimbingan.php` (`scopeValid`, `scopePending`, `scopeInvalid`) menggunakan lowercase `'valid'`, `'pending'`, `'invalid'`.
  - Ubah `MhsBimbinganController`: simpan dan kueri status sebagai lowercase `'pending'`.
  - Ubah aturan validasi Dosen & Admin menjadi `in:valid,invalid,pending,Valid,Invalid,Pending` dengan normalisasi `strtolower()` sebelum simpan.
- **Kriteria Penerimaan:** Statistik dashboard dosen dan mahasiswa menghitung jumlah status valid/pending/invalid secara akurat tanpa terpengaruh casing.
- **Risiko & Rollback:** Kompatibilitas mundur terjaga karena validasi menerima kedua format namun menyimpan dalam format lowercase kanonis.

---

### WP-04: Perbaikan Broken Route & Broken View Komentar Dosen & Admin Prodi [P1]
- **Target File:**
  - `app/Http/Controllers/Dosen/KomentarBimbinganController.php`
  - `resources/views/dosen/bimbingan/komentar.blade.php`
  - `app/Http/Controllers/Dosen/DosenBimbinganController.php`
  - `resources/views/admin/program_studi/index.blade.php`
  - `bootstrap/app.php` (case-sensitivity route file)
- **Tujuan:** Memperbaiki rute dan view yang rusak agar tidak menghasilkan HTTP 404/500.
- **Perubahan Rinci:**
  - Pada `KomentarBimbinganController::show`, ubah `view('dosen.bimbingan.komentar.show')` menjadi `view('dosen.bimbingan.komentar')`.
  - Pada `resources/views/dosen/bimbingan/komentar.blade.php`, perbaiki form action ke `route('bimbingan.komentar.store', $bimbingan->id_bimbingan)`.
  - Tambahkan implementasi method `deleteDokumen($id)` pada `DosenBimbinganController` dengan verifikasi kepemilikan bimbingan dosen.
  - Pada `resources/views/admin/program_studi/index.blade.php`, tambahkan prefix `/admin/` pada form action modal edit dan delete prodi (`url('/admin/program_studi')`).
  - Pada `bootstrap/app.php`, pastikan pemanggilan `routes/auth.php` atau `routes/Auth.php` konsisten dengan filesystem.
- **Kriteria Penerimaan:**
  - Endpoint GET komentar dosen tidak crash.
  - Endpoint DELETE dokumen dosen berjalan normal.
  - Modal edit/hapus Program Studi admin tidak menghasilkan 404.

---

### WP-05: Penambahan Field `fakultas` & Transaksi Database pada Registrasi [P1]
- **Target File:**
  - `app/Http/Controllers/Auth/AuthController.php`
  - `resources/views/auth/register_dosen.blade.php`
  - `app/Http/Controllers/Admin/UserController.php`
- **Tujuan:** Mencegah SQL exception kolom `fakultas` null dan mencegah timbulnya orphaned user saat registrasi.
- **Perubahan Rinci:**
  - Tambahkan pilihan dropdown `fakultas` pada formulir `register_dosen.blade.php` menggunakan daftar fakultas resmi.
  - Pada `AuthController::registerDosen`, tambahkan aturan validasi `'fakultas' => 'required|string'` dan teruskan ke `Dosen::create()`.
  - Bungkus `registerMahasiswa`, `registerDosen`, `storeDosen`, dan `storeMahasiswa` di dalam `DB::transaction(...)`.
- **Kriteria Penerimaan:** Calon dosen dapat mendaftar tanpa error SQL; jika terjadi kegagalan sistem, seluruh operasi rollback bersih.

---

### WP-06: Penyeragaman Path Avatar & Perbaikan Double Prefix Navbar [P2]
- **Target File:**
  - `app/Http/Controllers/Dosen/DosenProfileController.php`
  - `resources/views/components/navbar.blade.php`
  - `app/Models/User.php`
- **Tujuan:** Menghilangkan double prefix `profile/dosen/profile/dosen/` sehingga foto profil dosen tampil sempurna di navbar.
- **Perubahan Rinci:**
  - Standarkan nilai yang disimpan pada `$user->foto` di `DosenProfileController` hanya nama file (`$fileName`), konsisten dengan `UserProfileController` dan `MhsProfileController`.
  - Tambahkan logic cerdas di `navbar.blade.php` atau accessor di `User.php` untuk mendeteksi apakah `foto` sudah memiliki prefix folder atau belum.
- **Kriteria Penerimaan:** Foto avatar dosen tampil utuh pada navbar di semua ukuran layar.

---

### WP-07: Rate Limiting & Penguatan Integritas RoleMiddleware [P2]
- **Target File:**
  - `routes/Auth.php`
  - `app/Http/Middleware/RoleMiddleware.php`
  - `app/Models/User.php`
- **Tujuan:** Melindungi autentikasi dari brute-force dan mencegah bug otorisasi tipe data ketat.
- **Perubahan Rinci:**
  - Tambahkan `$casts = ['role' => 'integer'];` pada `User.php`.
  - Ubah pengecekan di `RoleMiddleware.php` menjadi `(int)$currentRole !== $requiredRole`.
  - Tambahkan middleware `throttle:6,1` pada `POST /login` dan `throttle:10,1` pada rute registrasi.
- **Kriteria Penerimaan:** Request login berulang > 6 kali per menit dibatasi dengan status 429 Too Many Requests; konversi role integer konsisten.

---

### WP-08: Penyesuaian `UserFactory.php` untuk Testing Integrity [P2]
- **Target File:** `database/factories/UserFactory.php`
- **Tujuan:** Menghilangkan kolom fiktif (`nik`, `google_id`, role desa) agar automated test berbasis factory dapat berjalan.
- **Perubahan Rinci:**
  - Sesuaikan atribut default pada `UserFactory::definition()`:
    ```php
    'username' => fake()->unique()->userName(),
    'email' => fake()->unique()->safeEmail(),
    'password' => static::$password ??= Hash::make('password'),
    'role' => fake()->randomElement([1, 2, 3]),
    'status_verifikasi' => 'Terverifikasi',
    'foto' => null,
    ```
- **Kriteria Penerimaan:** `User::factory()->make()` dan `create()` menghasilkan instance yang valid tanpa SQL exception.

---

### WP-09: Isolasi File Sisa Template Non-Domain [P3 — TERTUNDA / BUTUH PERSETUJUAN]
- **Target File:**
  - `app/Http/Controllers/AdministrasiController.php`
  - `app/Exports/ApbdesExport.php`
  - `database/factories/` (11 factory desa)
- **Tindakan Saat Ini:** Jangan menghapus file secara sepihak. Catat dalam daftar kandidat pembersihan (Cleanup Candidates) dan mintakan konfirmasi pemilik proyek sebelum dihapus.

---

## 3. Matriks Kesiapan Perubahan

| Work Package | Severity | Risiko Perubahan | Status Persetujuan | Siap Eksekusi? |
|---|---|---|---|---|
| WP-01 (Redaksi Secret) | P0 | Sangat Rendah | Mandiri (Guardrail Wajib) | Ya |
| WP-02 (Fix Stored XSS) | P1 | Rendah | Mandiri (Bug Fix Terarah) | Ya |
| WP-03 (Fix Enum Status) | P1 | Rendah | Mandiri (Bug Fix Terarah) | Ya |
| WP-04 (Fix Broken Routes/Views) | P1 | Rendah | Mandiri (Bug Fix Terarah) | Ya |
| WP-05 (Fix Registrasi Dosen & Transaksi) | P1 | Sedang | Mandiri (Bug Fix Terarah) | Ya |
| WP-06 (Fix Avatar Navbar) | P2 | Rendah | Mandiri (Bug Fix Terarah) | Ya |
| WP-07 (Rate Limit & Role Cast) | P2 | Rendah | Mandiri (Hardening) | Ya |
| WP-08 (Fix UserFactory) | P2 | Rendah | Mandiri (Testing Fix) | Ya |
| WP-09 (Hapus File Desa) | P3 | Rendah | Butuh Persetujuan Owner | Tunda |
