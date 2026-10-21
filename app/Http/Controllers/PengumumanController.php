<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = [
            [
                'judul' => 'Pengumuman Libur Nasional',
                'isi' => 'Sehubungan dengan libur nasional, seluruh kegiatan perkuliahan ditiadakan pada tanggal 1 Juli 2025.',
                'tanggal' => '2025-06-20',
                'kategori' => 'Libur'
            ],
            [
                'judul' => 'Pengisian KRS Semester Ganjil',
                'isi' => 'Pengisian KRS semester ganjil dibuka mulai tanggal 5 Juli 2025 hingga 15 Juli 2025.',
                'tanggal' => '2025-06-18',
                'kategori' => 'Akademik'
            ],
            [
                'judul' => 'Pembayaran SPP Semester Ganjil',
                'isi' => 'Batas waktu pembayaran SPP semester ganjil adalah tanggal 31 Juli 2025. Mohon segera lakukan pembayaran.',
                'tanggal' => '2025-06-15',
                'kategori' => 'Keuangan'
            ],
            [
                'judul' => 'Seminar Nasional Teknologi',
                'isi' => 'Akan diadakan seminar nasional teknologi pada tanggal 10 Agustus 2025. Pendaftaran dibuka mulai sekarang.',
                'tanggal' => '2025-06-12',
                'kategori' => 'Event'
            ]
        ];

        return view('pengumuman', compact('pengumuman'));
    }
}
