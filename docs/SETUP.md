# SETUP & INSTALLATION GUIDE

**Proyek:** Sistem Informasi Manajemen Bimbingan Akademik (SIM Bimbingan - UBSI)  
**Versi:** 1.0.0  
**Tanggal:** 21 Oktober 2026  

---

## 1. Prasyarat Sistem (Prerequisites)

- **PHP:** >= 8.2 (dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `gd`)
- **Composer:** >= 2.x
- **Node.js:** >= 20.x dan **npm** >= 10.x
- **Database Engine:** MySQL 8.x / MariaDB 10.x atau SQLite untuk pengujian lokal

---

## 2. Langkah Instalasi Cepat (Quick Start)

### 2.1 Clone dan Konfigurasi Environment
```bash
# Masuk ke direktori proyek
cd sim-main

# Salin template environment
cp .env.example .env

# Generate Application Key
php artisan key:generate
```

### 2.2 Konfigurasi Database pada `.env`
Buka file `.env` dan sesuaikan koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sim_bimbingan
DB_USERNAME=root
DB_PASSWORD=
```

### 2.3 Install Dependensi Backend & Frontend
```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 2.4 Jalankan Migrasi & Seeder Database
```bash
# Jalankan migrasi dan buat tabel
php artisan migrate

# Isi data master dan user awal (Admin, Dosen, Mahasiswa)
php artisan db:seed

# Buat symbolic link storage
php artisan storage:link
```

### 2.5 Build Aset Frontend
```bash
# Untuk pengembangan lokal dengan hot-reload
npm run dev

# Atau build untuk deployment produksi
npm run build
```

### 2.6 Jalankan Server Aplikasi
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://localhost:8000`

---

## 3. Akun Pengujian Default (Seeder Data)

| Role | Email | Password Default | Keterangan |
|---|---|---|---|
| **Admin** | `admin@example.com` | `password` | Administrator Utama |
| **Dosen** | `dosen1@example.com` | `password` | Dosen Pembimbing (NIDN: `D123456`) |
| **Mahasiswa** | `mahasiswa1@example.com` | `password` | Mahasiswa Bimbingan (NIM: `M2025001`) |

---

## 4. Pengujian Otomatis (Testing)
Aplikasi dilengkapi unit test dan feature test terotomasi menggunakan SQLite in-memory:
```bash
php artisan test
```
