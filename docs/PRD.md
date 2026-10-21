# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## Sistem Informasi Manajemen Bimbingan Akademik / Tugas Akhir (SIM Bimbingan)

**Status:** DRAFT — REQUIRES OWNER VALIDATION  
**Versi:** 1.0.0 (Hasil Rekonstruksi Evidence-Based)  
**Tanggal:** 21 Oktober 2026  
**Penulis:** Hermes Agent (Software Architect & Product Analyst)  

---

## 1. Ringkasan Eksekutif & Tujuan Produk

SIM Bimbingan adalah platform web terpadu yang dirancang untuk memfasilitasi, mencatat, dan memonitor proses bimbingan akademik, proposal skripsi, dan tugas akhir mahasiswa di Universitas BSI (UBSI). Sistem ini menghubungkan tiga pemangku kepentingan utama: Mahasiswa, Dosen Pembimbing, dan Administrator Program Studi.

### 1.1 Masalah yang Diselesaikan
- Dokumentasi bimbingan manual yang rentan hilang atau tidak terlacak.
- Kurangnya transparansi progres mahasiswa bagi dosen pembimbing dan koordinator program studi.
- Kesulitan validasi berkas lampiran (draft artikel, bab proposal, revisi skripsi).
- Waktu respon feedback bimbingan yang lambat akibat saluran komunikasi terpisah.

### 1.2 Metrik Keberhasilan (Inferred)
- Ketepatan waktu validasi pengajuan bimbingan oleh dosen pembimbing.
- Ketercapaian kuota minimum pertemuan bimbingan (misal 8-10 sesi) sebelum pendaftaran sidang tugas akhir.
- Riwayat diskusi dan revisi dokumen yang terekam rapi per sesi bimbingan.

---

## 2. Target Pengguna & Role

| Role ID | Role Name | Deskripsi & Hak Akses |
|---|---|---|
| `1` | **Administrator** | Manajemen master data (Program Studi, Tahun Ajar), manajemen akun pengguna (Admin, Dosen, Mahasiswa), monitoring seluruh data bimbingan, verifikasi akun. |
| `2` | **Dosen** | Melihat daftar mahasiswa yang dibimbing, meninjau pengajuan bimbingan, mengunduh draf dokumen, mengubah status validasi (`pending`, `valid`, `invalid`), memberikan catatan dan komentar diskusi bimbingan. |
| `3` | **Mahasiswa** | Mengajukan permohonan bimbingan baru dengan memilih dosen pembimbing, mengunggah draf dokumen (PDF/DOC), melihat status validasi, dan berdiskusi melalui kolom komentar bimbingan. |
| `Guest` | **Publik / Tamu** | Melihat landing page profil universitas dan berita pengumuman, serta mengakses formulir login dan registrasi. |

---

## 3. Fitur Utama & Functional Requirements

### 3.1 Modul Autentikasi & Akun
- **FR-001 (Registrasi Mahasiswa):** Calon mahasiswa dapat mendaftar dengan NIM (10 digit), nama lengkap, email, program studi, angkatan, dan kata sandi.
- **FR-002 (Registrasi Dosen):** Calon dosen dapat mendaftar dengan NIDN (10 digit), nama lengkap, email, jabatan fungsional, pilihan fakultas, dan kata sandi.
- **FR-003 (Login & Role Routing):** Pengguna login dengan email dan password. Sistem mengarahkan otomatis ke dashboard sesuai role (`/admin/dashboard`, `/dosen/dashboard`, `/mhs/dashboard`).
- **FR-004 (Manajemen Profil):** Setiap role dapat memperbarui informasi profil dan mengunggah foto avatar.

### 3.2 Modul Bimbingan Mahasiswa
- **FR-005 (Pengajuan Bimbingan):** Mahasiswa membuat pengajuan bimbingan dengan memilih Dosen Pembimbing, menentukan tanggal, menuliskan topik, catatan/deskripsi, serta melampirkan berkas PDF/DOC (maks 2MB).
- **FR-006 (Status Bimbingan):** Status awal pengajuan bimbingan adalah `pending`.
- **FR-007 (Edit & Hapus Pengajuan):** Mahasiswa hanya dapat mengedit atau menghapus pengajuan yang masih berstatus `pending`. Pengajuan yang telah di-review (`valid` atau `invalid`) terkunci dari modifikasi mahasiswa.
- **FR-008 (Komentar Mahasiswa):** Mahasiswa dapat mengirim komentar teks pada bimbingan miliknya untuk mendiskusikan revisi.

### 3.3 Modul Bimbingan Dosen
- **FR-009 (Dashboard Dosen & Notifikasi):** Dosen melihat ringkasan statistik bimbingan (total, selesai/valid, pending, invalid, bimbingan baru 24 jam terakhir) serta grafik tren bulanan.
- **FR-010 (Validasi Bimbingan):** Dosen meninjau topik dan dokumen bimbingan, memberikan catatan review, mengunggah dokumen revisi, dan menetapkan status validasi (`valid`, `invalid`, atau tetap `pending`).
- **FR-011 (Tandai Dibaca):** Dosen dapat menandai bimbingan baru sebagai "sudah dibaca" baik per item maupun massal.
- **FR-012 (Komentar Dosen):** Dosen dapat mengirim feedback bimbingan dan menghapus komentar yang ditulisnya sendiri.

### 3.4 Modul Administrasi (Admin)
- **FR-013 (Master Program Studi):** CRUD data program studi dan penugasan fakultas.
- **FR-014 (Master Tahun Ajar):** CRUD tahun ajaran dan semester aktif.
- **FR-015 (User Management):** Admin dapat membuat, melihat, mengedit, dan menghapus akun Admin, Dosen, dan Mahasiswa.
- **FR-016 (Bimbingan Monitoring):** Admin dapat melihat seluruh daftar bimbingan mahasiswa dan melakukan intervensi jika diperlukan.
- **FR-017 (Penugasan Dosen Pembimbing):** Admin dapat menetapkan atau mengubah Dosen Pembimbing resmi untuk setiap mahasiswa (`nidn_pembimbing`).

### 3.5 Fitur Kelayakan Sidang & Pelaporan Resmi
- **FR-018 (Gate & Rekomendasi ACC Sidang):** Dosen Pembimbing dapat memberikan status rekomendasi `ACC Siap Sidang` kepada mahasiswa bimbingannya yang telah menuntaskan seluruh bab skripsi dan memenuhi kuota bimbingan.
- **FR-019 (Cetak Kartu Kendali Bimbingan PDF/Print):** Mahasiswa, Dosen, dan Admin dapat mencetak Kartu Kendali Bimbingan resmi berformat standar A4 yang memuat kop universitas, identitas, judul skripsi, tabel sesi bimbingan tervalidasi, status ACC sidang, serta kolom tanda tangan dosen dan kaprodi.

---

## 4. State Transitions (Aturan Transisi Status Bimbingan)

```
[Draft Mahasiswa] 
       ↓ (Submit Form)
  ┌─────────┐
  │ PENDING │ ◄─── Dosen meminta revisi awal
  └────┬────┘
       ├─────────────────────┐
       ↓ (Dosen Menyetujui)  ↓ (Dosen Menolak/Revisi Total)
  ┌─────────┐           ┌─────────┐
  │  VALID  │           │ INVALID │
  └─────────┘           └─────────┘
```

---

## 5. Non-Functional Requirements (NFR)

- **Security:**
  - Password di-hash menggunakan algoritma Bcrypt (cost 12).
  - Rate limiting pada rute autentikasi untuk memitigasi brute-force attack.
  - Sanitasi input dan proteksi Stored XSS pada editor teks.
  - CSRF Token wajib pada seluruh request modifikasi state (POST, PUT, DELETE).
- **Performance:**
  - Asset frontend dibundel dan di-minifikasi via Vite (Tailwind CSS & Alpine.js).
  - Kueri Eloquent memanfaatkan eager loading (`with(['mahasiswa', 'dosen', 'dokumen'])`) untuk mencegah problem N+1 query.
- **Compatibility:**
  - Backend kompatibel dengan PHP >= 8.2 dan Laravel 11.
  - Database kompatibel dengan MySQL 8.x dan MariaDB.

---

## 6. PRD-to-Implementation Alignment

| Requirement ID | Implementasi Aktual di Kode | Status Keterpenuhan | Catatan |
|---|---|---|---|
| FR-001 | `AuthController::registerMahasiswa` | `PASS` | Dilengkapi transaksi database |
| FR-002 | `AuthController::registerDosen` | `PASS` | Dilengkapi input & validasi fakultas |
| FR-003 | `AuthController::authenticate` & `RoleMiddleware` | `PASS` | Strict integer role check |
| FR-004 | `UserProfileController`, `MhsProfileController`, `DosenProfileController` | `PASS` | Avatar url & path distandarkan |
| FR-005 | `MhsBimbinganController::store` | `PASS` | Status default lowercase `'pending'` |
| FR-006 - FR-008 | `MhsBimbinganController` & `KomentarMahasiswaController` | `PASS` | Gate status pending terpenuhi |
| FR-009 - FR-012 | `DashboardDosenController`, `DosenBimbinganController`, `KomentarBimbinganController` | `PASS` | Broken views & routes telah diperbaiki |
| FR-013 - FR-016 | `ProgramStudiController`, `TahunAjarController`, `UserController`, `BimbinganController` | `PASS` | Action modal URL prodi diperbaiki |
