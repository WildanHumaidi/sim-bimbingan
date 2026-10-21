<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KomentarBimbinganTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('komentar_bimbingan')->delete();
        
        \DB::table('komentar_bimbingan')->insert(array (
            0 => 
            array (
                'id_komentar' => 1,
                'id_bimbingan' => 6,
                'id_pengirim' => 2,
                'isi_komentar' => 'test',
                'waktu_kirim' => '2025-06-27 15:28:11',
                'tipe_pengirim' => 'dosen',
                'lampiran_url' => NULL,
            ),
            1 => 
            array (
                'id_komentar' => 2,
                'id_bimbingan' => 7,
                'id_pengirim' => 2,
                'isi_komentar' => 'oke sudah benar, tidak perlu bimbingan lagi',
                'waktu_kirim' => '2025-06-27 15:29:09',
                'tipe_pengirim' => 'dosen',
                'lampiran_url' => NULL,
            ),
        ));
        
        
    }
}