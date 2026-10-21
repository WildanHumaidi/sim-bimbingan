# DEEP BUG AUDIT & BUSINESS LOGIC REVIEW

**Proyek:** Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan - UBSI)  
**Tanggal Audit:** 21 Oktober 2026  
**Auditor:** Hermes Agent (Software Architect & QA Engineer)  
**Status Gate:** `REMEDIATION REQUIRED`  

---

## 1. Daftar Temuan Bug & Logika Bisnis

| ID | Judul Temuan | Severity | Confidence | Area / Modul |
|---|---|---|---|---|
| BUG-001 | Status Validasi Bimbingan Mismatch Casing (`'Pending'` vs `'pending'`) | `P1 High` | `Confirmed` | Bimbingan Models, Migrations, Controllers |
| BUG-002 | Broken Route & Broken View pada Komentar Bimbingan Dosen | `P1 High` | `Confirmed` | `KomentarBimbinganController`, `dosen/bimbingan/komentar.blade.php` |
| BUG-003 | Path URL dan Direktori Penyimpanan Dokumen Inkonsisten (404 Error) | `P1 High` | `Confirmed` | `MhsBimbinganController`, `Admin/BimbinganController`, Blade Views |
| BUG-004 | Admin Program Studi Form Action 404 (Missing `/admin/` Prefix) | `P1 High` | `Confirmed` | `resources/views/admin/program_studi/index.blade.php` |
| BUG-005 | Kolom Wajib `fakultas` Hilang pada Registrasi Dosen | `P1 High` | `Confirmed` | `AuthController::registerDosen`, `add_fakultas_ke_dosen` migration |
| BUG-006 | Double Prefix Path Foto Profil Dosen pada Navbar (Broken Avatar) | `P2 Medium` | `Confirmed` | `DosenProfileController`, `resources/views/components/navbar.blade.php` |
| BUG-007 | Nama Admin Tidak Pernah Tersimpan pada Edit Profil | `P2 Medium` | `Confirmed` | `UserProfileController::update`, `admin/profile.blade.php` |
| BUG-008 | UserFactory Rusak Akibat Kolom Fiktif / Sisa Proyek Lain | `P2 Medium` | `Confirmed` | `database/factories/UserFactory.php` |
| BUG-009 | Model Menginstansiasi Controller (`new FakController()`) | `P3 Low` | `Confirmed` | `app/Models/Dosen.php:39,47` |
| BUG-010 | Leftover Code & Missing Models (Administrasi, Apbdes, 11 Factories) | `P3 Low` | `Confirmed` | `AdministrasiController`, `ApbdesExport`, `database/factories/` |

---

## 2. Rincian Temuan

### BUG-001: Status Validasi Bimbingan Casing Mismatch (`Pending` vs `pending`)
- **Severity:** `P1 High`
- **Confidence:** `Confirmed`
- **Lokasi:**
  - Migrasi: `database/migrations/2025_06_23_173510_create_bimbingan_table.php:16`
  - Model: `app/Models/Bimbingan.php:72,80,88` (`scopeValid`, `scopePending`, `scopeInvalid`)
  - Kontroler Mahasiswa: `app/Http/Controllers/Mhs/MhsBimbinganController.php:99,143,169,175,219`
  - Kontroler Dosen: `app/Http/Controllers/Dosen/DosenBimbinganController.php:90`
  - Kontroler Admin: `app/Http/Controllers/Admin/BimbinganController.php:39,88`
  - Dashboard Dosen: `app/Http/Controllers/Dosen/DashboardDosenController.php:31,58,72,76`
  - Dashboard Mahasiswa: `app/Http/Controllers/Mhs/DashboardMhsController.php:31,34,37`
- **Expected vs Actual:**
  - *Expected:* Seluruh lapisan aplikasi menggunakan standar nilai status yang konsisten sesuai skema database ENUM: `'pending'`, `'valid'`, `'invalid'` (huruf kecil).
  - *Actual:* Migrasi mendefinisikan enum `['pending', 'valid', 'invalid']`. Model mendefinisikan scope dengan Title Case (`'Valid'`, `'Pending'`, `'Invalid'`). Mahasiswa menyimpan `'Pending'`, Dosen memvalidasi `'in:Valid,Invalid,Pending'`, sementara Dashboard Dosen & Mahasiswa mengkalkulasi statistik dengan `'valid'`, `'pending'`, `'invalid'`.
- **First Divergence:** Inkonsistensi antara penulisan ENUM di migrasi database dan nilai input di `MhsBimbinganController`/`Bimbingan.php`.
- **Root Cause:** Tidak adanya konstanta kanonikal (Class Constants / PHP Enum) untuk status bimbingan.
- **Dampak Teknis & Bisnis:**
  - Pada database case-sensitive (seperti PostgreSQL atau MySQL dengan collation tertentu), input `'Pending'` gagal constraint ENUM.
  - Statistik bimbingan selesai dan validasi di Dashboard Dosen dan Mahasiswa dapat bernilai 0 (kosong) karena kueri `where('status_validasi', 'valid')` tidak cocok dengan `'Valid'`.
- **Rekomendasi Perbaikan:**
  1. Definisikan konstanta kanonis pada model `Bimbingan`:
     ```php
     const STATUS_PENDING = 'pending';
     const STATUS_VALID = 'valid';
     const STATUS_INVALID = 'invalid';
     ```
  2. Standarkan seluruh migrasi, model scope, validasi form, dan kueri dashboard ke lowercase (`pending`, `valid`, `invalid`).
- **Test Regresi:** Buat unit/feature test yang membuat bimbingan, mengubah status, dan memverifikasi kalkulasi dashboard.

---

### BUG-002: Broken Route & Broken View pada Komentar Bimbingan Dosen
- **Severity:** `P1 High`
- **Confidence:** `Confirmed`
- **Lokasi:**
  - `app/Http/Controllers/Dosen/KomentarBimbinganController.php:82`
  - `resources/views/dosen/bimbingan/komentar.blade.php:81,113`
  - `routes/web.php:136-137`
- **Expected vs Actual:**
  - *Expected:* Dosen dapat membuka halaman detail komentar bimbingan dan melihat riwayat komentar tanpa error.
  - *Actual:*
    1. `KomentarBimbinganController::show()` memanggil `view('dosen.bimbingan.komentar.show')`. File tersebut tidak ada di disk (yang ada adalah `dosen.bimbingan.komentar`). Menghasilkan `InvalidArgumentException: View not found`.
    2. File `resources/views/dosen/bimbingan/komentar.blade.php` memanggil rute `dosen.komentar.destroy` dan `dosen.komentar.store` yang tidak pernah didaftarkan di `routes/web.php`. Menghasilkan `RouteNotFoundException`.
- **First Divergence:** Penamaan view path dan penamaan route mismatch antara route provider dan controller/blade.
- **Root Cause:** Perubahan nama rute dan struktur folder view komentar yang tidak tuntas.
- **Dampak Teknis & Bisnis:** Dosen mengalami error 500 fatal ketika membuka detail komentar bimbingan mahasiswa.
- **Rekomendasi Perbaikan:**
  1. Sesuaikan panggilan view di `KomentarBimbinganController::show` menjadi `dosen.bimbingan.komentar`.
  2. Perbaiki form action pada `komentar.blade.php` agar menggunakan `route('bimbingan.komentar.store', $bimbingan->id_bimbingan)`.
- **Test Regresi:** Feature test akses GET `/dosen/bimbingan/{id_bimbingan}/komentar/{id_komentar}`.

---

### BUG-003: Path URL dan Direktori Penyimpanan Dokumen Inkonsisten (404 Error)
- **Severity:** `P1 High`
- **Confidence:** `Confirmed`
- **Lokasi:**
  - Upload Mhs: `app/Http/Controllers/Mhs/MhsBimbinganController.php:114` (`public/doc/`)
  - Upload Dosen: `app/Http/Controllers/Dosen/DosenBimbinganController.php:103` (`storage/app/public/dokumen_bimbingan`)
  - Upload Admin: `app/Http/Controllers/Admin/BimbinganController.php:54` (`storage/app/public/dokumen_bimbingan`)
  - View Mhs & Dosen: `mhs/bimbingan/show.blade.php:232` (`/{{ $dokumen->file_path }}`)
  - View Admin: `admin/bimbingan/index.blade.php:73` (`storage/{{ $dokumen->file_path }}`)
- **Expected vs Actual:**
  - *Expected:* Seluruh dokumen bimbingan diunggah ke storage yang konsisten dan dapat diakses/diunduh oleh Admin, Dosen, dan Mahasiswa yang berhak.
  - *Actual:* Dokumen mahasiswa disimpan di `public/doc/` sedangkan Dosen/Admin disimpan di `storage/app/public/dokumen_bimbingan/`. Admin melihat link dokumen mahasiswa sebagai `storage/doc/...` (404 Not Found), sementara Mahasiswa melihat link dokumen dosen/admin sebagai `/dokumen_bimbingan/...` (404 Not Found).
- **First Divergence:** Penggunaan strategi upload ganda (`move(public_path())` vs `store(..., 'public')`).
- **Root Cause:** Kurangnya standardisasi layanan manajemen file dokumen.
- **Dampak Teknis & Bisnis:** Pengguna lintas peran tidak bisa membuka file lampiran bimbingan satu sama lain, menghentikan proses review skripsi.
- **Rekomendasi Perbaikan:** Standarkan penyimpanan dokumen menggunakan `Storage::disk('public')` (atau secure private disk), dan sediakan accessor `$dokumen->download_url` atau route streaming yang konsisten untuk semua peran.
- **Test Regresi:** Upload dokumen sebagai mahasiswa, lalu verifikasi link download dari akun Dosen dan Admin.

---

### BUG-004: Admin Program Studi Form Action 404 (Missing `/admin/` Prefix)
- **Severity:** `P1 High`
- **Confidence:** `Confirmed`
- **Lokasi:** `resources/views/admin/program_studi/index.blade.php:94,120`
- **Expected vs Actual:**
  - *Expected:* Form modal Edit dan Hapus Program Studi mengirim request ke `/admin/program_studi/{id}`.
  - *Actual:* Form mengirim request ke `{{ url('/program_studi') }}/${selectedProdi.id_prodi}` (tanpa prefix `/admin`).
- **First Divergence:** Kesalahan penulisan URL aksi modal di Blade.
- **Root Cause:** Tidak menggunakan helper `route('program_studi.update', ...)` atau `url('/admin/program_studi')`.
- **Dampak Teknis & Bisnis:** Admin tidak dapat mengupdate atau menghapus data Program Studi dari antarmuka web (menghasilkan HTTP 404 Not Found).
- **Rekomendasi Perbaikan:** Ubah URL di form modal menjadi `{{ url('/admin/program_studi') }}/${selectedProdi.id_prodi}`.
- **Test Regresi:** Uji submit PUT dan DELETE pada modul Program Studi Admin.

---

### BUG-005: Kolom Wajib `fakultas` Hilang pada Registrasi Dosen
- **Severity:** `P1 High`
- **Confidence:** `Confirmed`
- **Lokasi:**
  - `app/Http/Controllers/Auth/AuthController.php:118-138`
  - `database/migrations/2025_06_27_090110_add_fakultas_ke_dosen.php:10`
- **Expected vs Actual:**
  - *Expected:* Calon dosen dapat mendaftar mandiri melalui form registrasi dan data tersimpan lengkap ke tabel `users` dan `dosens`.
  - *Actual:* Migrasi menetapkan kolom `fakultas` NOT NULL tanpa default. Namun method `registerDosen` pada `AuthController` tidak meminta atau mengisi field `fakultas`, memicu error SQL constraint `Field 'fakultas' doesn't have a default value`.
- **First Divergence:** Migrasi kolom baru pada tabel `dosens` ditambahkan tanpa memperbarui form dan controller registrasi dosen.
- **Root Cause:** Penambahan skema tanpa pembaruan endpoint registrasi publik.
- **Dampak Teknis & Bisnis:** Registrasi dosen gagal total di lingkungan produksi dengan error database, dan meninggalkan data user gantung.
- **Rekomendasi Perbaikan:** Tambahkan validasi dan input `fakultas` pada form registrasi dosen serta controller `AuthController::registerDosen`.
- **Test Regresi:** Uji submit registrasi dosen baru dengan data valid.

---

### BUG-006: Double Prefix Path Foto Profil Dosen pada Navbar (Broken Avatar)
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:**
  - `app/Http/Controllers/Dosen/DosenProfileController.php:76`
  - `resources/views/components/navbar.blade.php:70`
- **Expected vs Actual:**
  - *Expected:* Foto profil dosen tampil normal pada navbar.
  - *Actual:* `DosenProfileController` menyimpan nilai `$user->foto = 'profile/dosen/' . $fileName`. Di `navbar.blade.php`, kode menambahkan lagi prefix: `'profile/dosen/' . Auth::user()->foto`, menghasilkan `'profile/dosen/profile/dosen/file.jpg'`, menyebabkan gambar avatar pecah (broken image 404).
- **First Divergence:** Inkonsistensi format penyimpanan kolom `foto` di tabel `users`.
- **Root Cause:** Admin dan Mahasiswa hanya menyimpan nama file (`fileName`), sedangkan Dosen menyimpan relative path (`profile/dosen/fileName`).
- **Dampak Teknis & Bisnis:** Antarmuka tampak rusak / tidak profesional bagi pengguna dosen.
- **Rekomendasi Perbaikan:** Standarkan penyimpanan nilai kolom `foto` di seluruh controller profil menjadi hanya nama file, atau buat accessor kanonis `getAvatarUrlAttribute()` di model `User`.
- **Test Regresi:** Upload foto profil dosen dan periksa tampilan navbar di desktop dan mobile.

---

### BUG-007: Nama Admin Tidak Pernah Tersimpan pada Edit Profil
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Http/Controllers/UserProfileController.php:38-45`, `resources/views/admin/profile.blade.php`
- **Expected vs Actual:**
  - *Expected:* Admin dapat mengubah nama lengkapnya pada halaman Edit Profil.
  - *Actual:* Tabel `users` tidak memiliki kolom `nama`. Kode hanya mengecek `if ($user->mahasiswa)` dan `elseif ($user->dosen)`. Untuk user Admin, kedua relasi tersebut null, sehingga input `$request->nama` dibuang tanpa disimpan. Saat halaman dimuat ulang, nama kembali ke nilai `username`.
- **First Divergence:** Asumsi bahwa semua user memiliki profil mahasiswa/dosen untuk menyimpan atribut `nama`.
- **Root Cause:** Ketiadaan kolom `nama` pada tabel `users`.
- **Dampak Teknis & Bisnis:** Perubahan nama admin tidak pernah tersimpan meskipun antarmuka melaporkan "Profil berhasil diperbarui".
- **Rekomendasi Perbaikan:** Gunakan fallback atau sinkronisasi dengan kolom yang tersedia, atau tambahkan kolom `nama` pada tabel `users` bila disetujui.
- **Test Regresi:** Update profil admin dan verifikasi nilai nama pasca reload.

---

### BUG-008: UserFactory Rusak Akibat Kolom Fiktif / Sisa Proyek Lain
- **Severity:** `P2 Medium`
- **Confidence:** `Confirmed`
- **Lokasi:** `database/factories/UserFactory.php:28,31,32`
- **Expected vs Actual:**
  - *Expected:* `User::factory()->create()` menghasilkan record user valid untuk automated testing.
  - *Actual:* Factory mendefinisikan kolom `'nik'`, `'google_id'`, dan role `['admin', 'user', 'kepala desa']` yang tidak ada di skema database, memicu exception `Unknown column in field list`.
- **First Divergence:** Factory disalin dari proyek sistem desa tanpa penyesuaian skema SIM Bimbingan.
- **Root Cause:** Leftover code template.
- **Dampak Teknis & Bisnis:** Seluruh test suite yang memanfaatkan factory user tidak dapat berjalan.
- **Rekomendasi Perbaikan:** Perbarui `UserFactory` agar sesuai skema tabel `users` (`username`, `email`, `password`, `role` [1, 2, 3], `status_verifikasi`).
- **Test Regresi:** Jalankan eksekusi `User::factory()->make()` dan `create()`.

---

### BUG-009: Model Menginstansiasi Controller (`new FakController()`)
- **Severity:** `P3 Low`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Models/Dosen.php:39,47`
- **Expected vs Actual:**
  - *Expected:* Model Eloquent tidak bergantung pada HTTP Controller.
  - *Actual:* Model `Dosen` membuat instance `new FakController()` untuk memvalidasi dan mengambil daftar fakultas.
- **First Divergence:** Pelanggaran prinsip separation of concerns.
- **Root Cause:** Ketiadaan domain service/config enum untuk fakultas.
- **Dampak Teknis & Bisnis:** Koppling kode buruk, mempersulit unit testing model secara terisolasi.
- **Rekomendasi Perbaikan:** Gunakan file konfigurasi `config('fakultas.list')` yang sudah ada di proyek.
- **Test Regresi:** Panggil `Dosen::getListFakultas()` dan pastikan mengembalikan array fakultas yang benar.

---

### BUG-010: Leftover Code & Missing Models (Administrasi, Apbdes, 11 Factories)
- **Severity:** `P3 Low`
- **Confidence:** `Confirmed`
- **Lokasi:** `app/Http/Controllers/AdministrasiController.php`, `app/Exports/ApbdesExport.php`, `database/factories/` (11 files)
- **Expected vs Actual:**
  - *Expected:* Codebase hanya berisi file yang relevan dengan domain SIM Bimbingan Akademik.
  - *Actual:* Terdapat kontroler administrasi desa, export Excel APBDes, dan 11 file factory yang memanggil model non-existent.
- **First Divergence:** Sisa boilerplate dari template awal.
- **Root Cause:** Codebase belum dibersihkan saat repositori diadaptasi untuk sistem bimbingan.
- **Dampak Teknis & Bisnis:** Clutter, kebingungan arsitektur, dan potensi error fatal jika file terpanggil.
- **Rekomendasi Perbaikan:** Dokumentasikan kandidat cleanup untuk konfirmasi penghapusan aman.
- **Test Regresi:** Pastikan penghapusan/isolasi tidak memutus routing bimbingan aktif.
