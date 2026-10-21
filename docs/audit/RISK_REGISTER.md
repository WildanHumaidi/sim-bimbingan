# PROJECT RISK REGISTER

**Proyek:** Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan - UBSI)  
**Tanggal:** 21 Oktober 2026  
**Auditor:** Hermes Agent (Software Architect & DevSecOps Reviewer)  

---

## 1. Matriks Risiko

| Tingkat Dampak \ Kemungkinan | Rendah (Low) | Sedang (Medium) | Tinggi (High) |
|---|---|---|---|
| **Kritis (Critical)** | - | **RSK-001** (Paparan Kredensial DB) | - |
| **Tinggi (High)** | **RSK-005** (Penghapusan Cascading) | **RSK-002** (Stored XSS) <br> **RSK-003** (Kebocoran Dokumen) | **RSK-004** (Kegagalan Enum Bimbingan) |
| **Sedang (Medium)** | **RSK-007** (Orphaned Users) | **RSK-006** (Broken Feature Program Studi) | **RSK-008** (Broken Image Avatar) |
| **Rendah (Low)** | **RSK-010** (Leftover Code Clutter) | **RSK-009** (Brute Force Auth) | - |

---

## 2. Rincian Risiko Bisnis & Teknis

### RSK-001: Eksfiltrasi atau Korupsi Database Cloud Akibat Paparan Kredensial `.env.example`
- **Kategori:** Keamanan / Kerahasiaan Data
- **Skenario:** Penyerang menemukan username `root`, password plaintext, host Railway, dan port database pada file `.env.example` yang dapat diakses publik atau di-push ke GitHub.
- **Pihak Terdampak:** Universitas, Seluruh Mahasiswa, Dosen, Administrator, Pemilik Infrastruktur Cloud.
- **Kemungkinan:** Sedang (Medium) — Sangat tinggi bila repository di-push ke public remote tanpa pembersihan.
- **Dampak:** Kritis (Critical) — Seluruh data akademik dapat dicuri, diubah, atau dihapus (Ransomware / Data Breach).
- **Mitigasi:**
  1. Rotasi instan password database di Railway console dan revoke kredensial lama.
  2. Redaksi `.env.example` ke nilai dummy lokal.
  3. Pastikan `.env` terdaftar pada `.gitignore`.
- **Suggested Owner:** Lead DevOps / Project Owner.
- **Residual Risk:** Rendah (setelah rotasi kredensial remote berhasil dilakukan).

---

### RSK-002: Pengambilalihan Akun Administrator Melalui Stored XSS pada Topik Bimbingan
- **Kategori:** Keamanan / Integritas Sistem
- **Skenario:** Mahasiswa nakal atau pihak ketiga mendaftarkan topik bimbingan dengan muatan payload script JavaScript. Saat Admin membuka formulir edit bimbingan, script tereksekusi dengan hak akses Admin, mencuri cookie sesi atau membuat akun admin baru secara otomatis.
- **Pihak Terdampak:** Administrator Sistem, Integritas Seluruh Data Bimbingan.
- **Kemungkinan:** Sedang (Medium) — Membutuhkan mahasiswa terdaftar yang memasukkan payload.
- **Dampak:** Tinggi (High) — Kompromi penuh hak akses administratif.
- **Mitigasi:** Sanitasi dan escape output pada `resources/views/admin/bimbingan/edit.blade.php` menggunakan `@js()` dan escaping Blade standar `{{ ... }}`.
- **Suggested Owner:** Frontend / Backend Engineer.
- **Residual Risk:** Sangat Rendah (setelah escape diterapkan).

---

### RSK-003: Kebocoran Data Hak Cipta / Skripsi Mahasiswa pada Penyimpanan Dokumen Publik
- **Kategori:** Privasi / Kepatuhan
- **Skenario:** Draft karya ilmiah, skripsi, atau data sensitif yang diunggah ke `public/doc` dapat di-scrape atau diunduh oleh pihak luar yang menebak pola timestamp nama file.
- **Pihak Terdampak:** Mahasiswa (plagiasi skripsi sebelum sidang), Universitas.
- **Kemungkinan:** Sedang (Medium).
- **Dampak:** Tinggi (High) — Pelanggaran privasi karya tulis ilmiah.
- **Mitigasi:** Pindahkan penyimpanan dokumen ke private disk dengan access-controlled route streaming.
- **Suggested Owner:** Backend Engineer.
- **Residual Risk:** Rendah.

---

### RSK-004: Data Mismatch & Kegagalan Transisi Status Validasi Bimbingan
- **Kategori:** Fungsional & Integritas Bisnis
- **Skenario:** Casing status validasi bimbingan yang berbeda (`'Pending'` vs `'pending'`, `'Valid'` vs `'valid'`) menyebabkan bimbingan yang disetujui dosen tidak terhitung di dashboard progres mahasiswa, menghalangi syarat kelulusan/sidang.
- **Pihak Terdampak:** Mahasiswa, Dosen Pembimbing, Bagian Akademik.
- **Kemungkinan:** Tinggi (High) — Sudah terjadi inkonsistensi di kode saat ini.
- **Dampak:** Tinggi (High) — Hambatan proses kelulusan dan pelaporan akademik.
- **Mitigasi:** Standardisasi nilai ENUM ke lowercase di model, kontroler, migrasi, dan antarmuka.
- **Suggested Owner:** Backend Engineer.
- **Residual Risk:** Nol setelah penyeragaman kode dan data.

---

### RSK-005: Kehilangan Data Riwayat Bimbingan Akibat Penghapusan Akun Pengguna
- **Kategori:** Integritas Data & Audit Trail
- **Skenario:** Admin menghapus akun mahasiswa atau dosen lama; relasi cascade (`onDelete('cascade')`) secara otomatis menghapus seluruh rekaman bimbingan, dokumen, dan komentar bimbingan yang terkait tanpa ada soft delete atau arsip riwayat.
- **Pihak Terdampak:** Bagian Akademik, Auditor Mutu Akademik.
- **Kemungkinan:** Rendah (Low) — Hanya terjadi saat ada aksi penghapusan user.
- **Dampak:** Tinggi (High) — Bukti proses bimbingan masa lalu hilang permanen.
- **Mitigasi:** Implementasikan `SoftDeletes` pada model bimbingan dan user, serta tambahkan konfirmasi pencegahan penghapusan akun yang memiliki riwayat bimbingan aktif.
- **Suggested Owner:** Software Architect / Database Engineer.
- **Residual Risk:** Rendah.

---

### RSK-006: Kegagalan Pengelolaan Program Studi oleh Administrator
- **Kategori:** Fungsional
- **Skenario:** Form edit dan hapus Program Studi menghasilkan error 404 karena path action URL tidak menyertakan prefix `/admin/`.
- **Pihak Terdampak:** Administrator.
- **Kemungkinan:** Tinggi (High) — Terjadi setiap kali admin mencoba mengedit/menghapus prodi.
- **Dampak:** Sedang (Medium) — Operasi CRUD prodi terblokir.
- **Mitigasi:** Perbaiki URL pada modal Blade `resources/views/admin/program_studi/index.blade.php`.
- **Suggested Owner:** Frontend Engineer.
- **Residual Risk:** Nol setelah perbaikan URL.

---

### RSK-007: Terbentuknya Akun User Gantung (Orphaned Records) Saat Registrasi Gagal
- **Kategori:** Konsistensi Basis Data
- **Skenario:** Input registrasi mahasiswa/dosen gagal pada tahap insert profil (misal field `fakultas` null pada dosen). Karena tidak ada transaksi (`DB::transaction`), record pada tabel `users` sudah terbuat sedangkan profil tidak ada. Email/NIM/NIDN terkunci dan tidak bisa didaftarkan ulang.
- **Pihak Terdampak:** Calon Pengguna Baru, Helpdesk Akademik.
- **Kemungkinan:** Sedang (Medium) — Pasti terjadi pada registrasi dosen baru di kode saat ini.
- **Dampak:** Sedang (Medium) — Pengguna tidak dapat mendaftar mandiri.
- **Mitigasi:** Bungkus registrasi multi-tabel dalam `DB::transaction` dan lengkapi input wajib `fakultas`.
- **Suggested Owner:** Backend Engineer.
- **Residual Risk:** Nol setelah penambahan transaksi database.

---

### RSK-008: Tampilan Antarmuka Pengguna Rusak Akibat Path Avatar Ganda
- **Kategori:** User Experience / Kualitas
- **Skenario:** Dosen login dan melihat avatar profil di navbar pecah / tidak muncul (404) karena double prefix `profile/dosen/profile/dosen/xxx.jpg`.
- **Pihak Terdampak:** Dosen.
- **Kemungkinan:** Tinggi (High) — Berlaku untuk semua akun dosen yang memiliki foto profil.
- **Dampak:** Sedang (Medium) — Menurunkan reputasi kualitas sistem informasi kampus.
- **Mitigasi:** Standarkan format penyimpanan foto profil dan perbaiki resolusi URL di navbar.
- **Suggested Owner:** Frontend / Backend Engineer.
- **Residual Risk:** Nol setelah standarisasi.

---

### RSK-009: Serangan Brute Force Kata Sandi Pengguna
- **Kategori:** Keamanan Akun
- **Skenario:** Penyerang mencoba ribuan kombinasi password pada endpoint `/login` tanpa terhalang batas frekuensi (rate limit).
- **Pihak Terdampak:** Seluruh Pengguna Sistem.
- **Kemungkinan:** Sedang (Medium).
- **Dampak:** Sedang (Medium) — Potensi akun mahasiswa/dosen tertebak jika menggunakan kata sandi lemah.
- **Mitigasi:** Pasang rate limiting `throttle:5,1` pada rute login.
- **Suggested Owner:** DevSecOps / Backend Engineer.
- **Residual Risk:** Rendah.

---

### RSK-010: Kebingungan Arsitektur & Risiko Pemeliharaan dari File Sisa Sistem Lain
- **Kategori:** Maintainability & Technical Debt
- **Skenario:** Pengembang baru melihat file APBDes, Administrasi Desa, dan 11 model factory fiktif, mengira ada fitur pemerintahan desa di dalam SIM Bimbingan Akademik.
- **Pihak Terdampak:** Tim Pengembang / Maintainer.
- **Kemungkinan:** Rendah (Low).
- **Dampak:** Rendah (Low) — Menambah technical debt dan potensi noise saat audit.
- **Mitigasi:** Pisahkan dan bersihkan file sisa template yang tidak digunakan setelah konfirmasi aman.
- **Suggested Owner:** Senior Engineer.
- **Residual Risk:** Nol setelah pembersihan.
