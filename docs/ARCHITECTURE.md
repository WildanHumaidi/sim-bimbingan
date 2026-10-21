# SYSTEM ARCHITECTURE DOCUMENTATION

**Proyek:** Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan - UBSI)  
**Versi:** 1.0.0  
**Tanggal:** 21 Oktober 2026  
**Penulis:** Hermes Agent (Software Architect)  

---

## 1. Arsitektur Tingkat Tinggi (High-Level Architecture)

SIM Bimbingan mengadopsi pola arsitektur **Monolith MVC (Model-View-Controller)** berbasis framework **Laravel 11**, dengan antarmuka dinamis bertenaga **Blade Templates**, **Tailwind CSS**, dan **Alpine.js**.

```
┌─────────────────────────────────────────────────────────────┐
│                       Client Browser                        │
│               (Desktop & Mobile Responsive)                 │
└──────────────────────────────┬──────────────────────────────┘
                               │ HTTP / HTTPS
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                    Web Server & Routing                     │
│                (public/index.php, web.php)                  │
└──────────────────────────────┬──────────────────────────────┘
                               │
            ┌──────────────────┴──────────────────┐
            ▼                                     ▼
┌───────────────────────┐             ┌───────────────────────┐
│ Global & Web          │             │ Role Middleware       │
│ Middleware (CSRF,     │             │ (Admin=1, Dosen=2,    │
│ Sessions, Cookies)    │             │  Mahasiswa=3)         │
└───────────┬───────────┘             └───────────┬───────────┘
            └──────────────────┬──────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                     Controller Layer                        │
│  - Auth\AuthController        - Dosen\DosenBimbingan        │
│  - Mhs\MhsBimbingan           - Admin\UserController        │
│  - Dosen\DashboardDosen       - Admin\BimbinganController   │
└──────────────────────────────┬──────────────────────────────┘
                               │
            ┌──────────────────┴──────────────────┐
            ▼                                     ▼
┌───────────────────────┐             ┌───────────────────────┐
│  Presentation Layer   │             │   Domain Data Layer   │
│  (Blade + Alpine.js   │             │   (Eloquent Models &  │
│   + Chart.js)         │             │    Database Migrations│
└───────────────────────┘             └───────────┬───────────┘
                                                  │
                                                  ▼
                                      ┌───────────────────────┐
                                      │      Storage & DB     │
                                      │  - MySQL / SQLite DB  │
                                      │  - Storage Disk Public│
                                      └───────────────────────┘
```

---

## 2. Diagram Alur Utama (Mermaid Sequence Diagrams)

### 2.1 Alur Pengajuan Bimbingan oleh Mahasiswa

```mermaid
sequenceDiagram
    actor M as Mahasiswa
    participant V as View (mhs.bimbingan.create)
    participant C as MhsBimbinganController
    participant S as Storage Service
    participant DB as MySQL Database

    M->>V: Isi formulir (Dosen, Topik, Catatan, Dokumen PDF)
    V->>C: POST /mhs/bimbingan
    C->>C: Validasi Request (role=3, file mimes:pdf,doc)
    C->>DB: INSERT bimbingan (status_validasi='pending')
    opt Ada Dokumen Diunggah
        C->>S: Store file ke storage
        C->>DB: INSERT dokumen (id_bimbingan, file_path)
    end
    C-->>M: Redirect ke /mhs/bimbingan dengan pesan sukses
```

### 2.2 Alur Validasi dan Review oleh Dosen

```mermaid
sequenceDiagram
    actor D as Dosen
    participant Dashboard as Dosen Dashboard
    participant C as DosenBimbinganController
    participant K as KomentarBimbinganController
    participant DB as MySQL Database

    D->>Dashboard: Akses Dashboard Dosen
    Dashboard->>DB: Query bimbingan (NIDN dosen, status baca, chart)
    D->>C: GET /dosen/bimbingan/{id}
    C->>DB: Fetch Bimbingan + Mahasiswa + Dokumen + Komentar
    C-->>D: Render halaman review
    D->>C: PUT /dosen/bimbingan/{id} (status='valid'/'invalid', catatan)
    C->>DB: UPDATE bimbingan
    D->>K: POST /dosen/bimbingan/{id}/komentar (Tulis saran revisi)
    K->>DB: INSERT komentar_bimbingan
    K-->>D: Refresh halaman bimbingan dengan riwayat komentar
```

---

## 3. Strategi Penyimpanan File & Dokumen (Storage Architecture)

1. **Penyimpanan Dokumen Bimbingan:**
   - Disimpan pada storage disk yang terdaftar di `config/filesystems.php`.
   - Menggunakan accessor `getPublicUrlAttribute()` di model `Dokumen` yang menjamin link download tetap valid untuk berkas lama (`doc/...`) maupun berkas baru (`storage/...`).
   - Symbolic link aktif: `public/storage` mengarah ke `storage/app/public`.
2. **Penyimpanan Foto Profil (Avatar):**
   - Disimpan di `public/profile/{role}/`.
   - Model `User` menyediakan atribut kanonis `avatar_url` dengan fallback aman ke `img/default-avatar.png` untuk mencegah tampilan broken image.

---

## 4. Keamanan & RBAC (Role-Based Access Control)

- **Role ID Definition:**
  - `1`: Administrator
  - `2`: Dosen
  - `3`: Mahasiswa
- **Middleware Guard:**
  - `auth`: Memastikan request berasal dari sesi yang telah login.
  - `role:{id}`: Mengevaluasi integer role pengguna terhadap role target. Jika tidak cocok, pengguna dialihkan otomatis ke dashboard perannya masing-masing.
- **Integritas Transaksi:** Operasi multi-tabel (pembuatan user + profil mahasiswa/dosen) dijamin atomis melalui `DB::transaction(...)`.
