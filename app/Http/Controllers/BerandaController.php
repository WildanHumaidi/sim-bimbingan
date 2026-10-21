<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        // Data statis, berbentuk object agar bisa diakses dengan ->property di Blade
        $berita = collect([
            (object)[
                'id_berita' => 1,
                'judul_berita' => 'Teknologi AI Dorong Inovasi',
                'isi_berita' => 'Perkembangan AI mempercepat perubahan di berbagai industri.',
                'tanggal_publish' => '2025-06-24',
                'gambar_cover' => 'berita1.jpg',
            ],
            (object)[
                'id_berita' => 2,
                'judul_berita' => 'Mahasiswa Indonesia Raih Prestasi',
                'isi_berita' => 'Tim mahasiswa memenangkan kompetisi internasional bidang teknologi.',
                'tanggal_publish' => '2025-06-23',
                'gambar_cover' => 'berita2.jpg',
            ],
            (object)[
                'id_berita' => 3,
                'judul_berita' => 'Universitas Buka Prodi Baru',
                'isi_berita' => 'Program studi baru bidang Teknologi Hijau resmi dibuka.',
                'tanggal_publish' => '2025-06-22',
                'gambar_cover' => 'berita3.jpg',
            ],
        ]);

        return view('welcome', [
            'berita' => $berita
        ]);
    }
}
