# SPECIFICATION DOCUMENTATION & ENDPOINT CONTRACT

**Proyek:** Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan - UBSI)  
**Versi:** 1.0.0  
**Tanggal:** 21 Oktober 2026  
**Penulis:** Hermes Agent (Software Architect)  

---

## 1. Daftar Rute Publik & Autentikasi

### 1.1 Rute Publik (Guest)

| Method | Endpoint | Handler | Deskripsi |
|---|---|---|---|
| `GET` | `/` | `BerandaController@index` | Menampilkan landing page profil universitas & artikel |
| `GET` | `/profil-ubsi` | `ProfilebsiController@index` | Menampilkan sejarah dan profil kampus |
| `GET` | `/ubsi` | `ProfilebsiController@index` | Alias rute peraturan & profil |
| `GET` | `/login` | `AuthController@showLoginForm` | Menampilkan formulir login |
| `POST` | `/login` | `AuthController@authenticate` | Memproses login (rate limit 10/min) |
| `GET` | `/register/mahasiswa` | `AuthController@showMahasiswaRegistrationForm` | Formulir pendaftaran mahasiswa |
| `POST` | `/register/mahasiswa` | `AuthController@registerMahasiswa` | Menyimpan registrasi mahasiswa |
| `GET` | `/register/dosen` | `AuthController@showDosenRegistrationForm` | Formulir pendaftaran dosen |
| `POST` | `/register/dosen` | `AuthController@registerDosen` | Menyimpan registrasi dosen |
| `POST` | `/logout` | `AuthController@logout` | Mengakhiri sesi (Middleware: `auth`) |

---

## 2. Rute Mahasiswa (`prefix: mhs`, Middleware: `auth`, `role:3`)

| Method | Endpoint | Name | Deskripsi |
|---|---|---|---|
| `GET` | `/mhs/dashboard` | `mahasiswa.dashboard` | Dashboard progres bimbingan mahasiswa |
| `GET` | `/mhs/profil` | `mhs.profile.edit` | Formulir edit profil mahasiswa |
| `POST` | `/mhs/profil` | `mhs.profile.update` | Simpan perubahan profil & foto |
| `GET` | `/mhs/bimbingan` | `mhs.bimbingan.index` | Daftar sesi bimbingan milik mahasiswa |
| `GET` | `/mhs/bimbingan/kartu-kendali` | `mhs.bimbingan.kartu-kendali` | Halaman cetak Kartu Kendali Bimbingan resmi |
| `GET` | `/mhs/bimbingan/create` | `mhs.bimbingan.create` | Formulir pengajuan bimbingan baru |
| `POST` | `/mhs/bimbingan` | `mhs.bimbingan.store` | Simpan pengajuan bimbingan & upload file |
| `GET` | `/mhs/bimbingan/{id}` | `mhs.bimbingan.show` | Detail bimbingan & utas diskusi |
| `GET` | `/mhs/bimbingan/{id}/edit` | `mhs.bimbingan.edit` | Edit bimbingan (Hanya jika status `pending`) |
| `PUT` | `/mhs/bimbingan/{id}` | `mhs.bimbingan.update` | Update bimbingan (Hanya jika status `pending`) |
| `DELETE` | `/mhs/bimbingan/{id}` | `mhs.bimbingan.destroy` | Hapus pengajuan (Hanya jika status `pending`) |
| `POST` | `/mhs/bimbingan/{id}/komentar` | `bim.komentar.store` | Kirim komentar pada bimbingan |

---

## 3. Rute Dosen (`prefix: dosen`, Middleware: `auth`, `role:2`)

| Method | Endpoint | Name | Deskripsi |
|---|---|---|---|
| `GET` | `/dosen/dashboard` | `dosen.dashboard` | Dashboard statistik dosen |
| `GET` | `/dosen/dashboard/check-new-bimbingan` | `dosen.check-new-bimbingan` | Cek bimbingan baru 24 jam terakhir (JSON) |
| `POST` | `/dosen/dashboard/tandai-dibaca/{id}` | `dosen.mark-as-read` | Tandai bimbingan dibaca per ID (JSON) |
| `POST` | `/dosen/dashboard/tandai-semua-dibaca` | `dosen.mark-all-read` | Tandai semua bimbingan dibaca (JSON) |
| `GET` | `/dosen/dashboard/statistik` | `dosen.statistik` | Data statistik lengkap untuk grafik (JSON) |
| `GET` | `/dosen/dashboard/bimbingan/{status}` | `dosen.bimbingan-by-status` | Filter bimbingan berdasarkan status baca (JSON) |
| `GET` | `/dosen/profil` | `dosen.profile.edit` | Formulir edit profil dosen |
| `POST` | `/dosen/profil` | `dosen.profile.update` | Simpan profil dosen |
| `GET` | `/dosen/bimbingan` | `dosen.bimbingan.index` | Daftar mahasiswa bimbingan yang masuk |
| `GET` | `/dosen/bimbingan/kartu-kendali/{nim}` | `dosen.bimbingan.kartu-kendali` | Cetak Kartu Kendali mahasiswa tertentu |
| `POST` | `/dosen/mahasiswa/{nim}/acc-sidang` | `dosen.mahasiswa.acc-sidang` | Dosen memberikan rekomendasi ACC Sidang |
| `GET` | `/dosen/bimbingan/{id}` | `dosen.bimbingan.show` | Halaman review & validasi bimbingan |
| `GET` | `/dosen/bimbingan/{id}/edit` | `dosen.bimbingan.edit` | Form ubah status & catatan validasi |
| `PUT` | `/dosen/bimbingan/{id}` | `dosen.bimbingan.update` | Simpan keputusan status (`valid`, `invalid`) |
| `DELETE` | `/dosen/bimbingan/dokumen/{id}` | `dosen.bimbingan.dokumen.delete` | Hapus dokumen lampiran |
| `POST` | `/dosen/bimbingan/{id}/komentar` | `bimbingan.komentar.store` | Kirim feedback revisi ke mahasiswa |
| `GET` | `/dosen/bimbingan/{id}/komentar/{id_k}` | `bimbingan.komentar.show` | Lihat detail utas komentar tertentu |
| `DELETE` | `/dosen/bimbingan/komentar/{id}` | `dosen.komentar.destroy` | Hapus komentar dosen sendiri |

---

## 4. Rute Admin (`prefix: admin`, Middleware: `auth`, `role:1`)

| Method | Endpoint | Name | Deskripsi |
|---|---|---|---|
| `GET` | `/admin/dashboard` | `dashboard.index` | Ringkasan statistik pengguna sistem |
| `GET` | `/admin/profil` | `profile.edit` | Edit profil administrator |
| `POST` | `/admin/profil` | `profile.update` | Update profil admin (AJAX JSON) |
| `GET` | `/admin/users` | `admin.users.index` | Daftar seluruh akun pengguna |
| `GET` | `/admin/users/create/{role}` | `admin.users.create.{role}` | Form pembuatan user sesuai role |
| `POST` | `/admin/users/store/{role}` | `admin.store.{role}` | Simpan user baru (Admin/Dosen/Mahasiswa) |
| `GET` | `/admin/users/{user}/edit/{role}` | `admin.edit.{role}` | Form edit data user & profil terkait |
| `PUT` | `/admin/users/{user}/update/{role}` | `admin.update.{role}` | Update data user & profil terkait |
| `DELETE` | `/admin/users/{user}` | `admin.destroy` | Hapus akun pengguna |
| `RESOURCE` | `/admin/program_studi` | `program_studi.*` | CRUD master data program studi |
| `RESOURCE` | `/admin/tahun_ajar` | `tahun_ajar.*` | CRUD master data tahun ajaran |
| `GET` | `/admin/bimbingan/kartu-kendali/{nim}` | `admin.bimbingan.kartu-kendali` | Cetak Kartu Kendali mahasiswa tertentu |
| `RESOURCE` | `/admin/bimbingan` | `bimbingan.*` | Monitoring & manajemen seluruh bimbingan |
