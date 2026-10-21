<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BimbinganTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bimbingan')->delete();
        
        \DB::table('bimbingan')->insert(array (
            0 => 
            array (
                'id_bimbingan' => 4,
                'nim' => 'M2025001',
                'nidn' => 'D123456',
                'tanggal' => '2025-06-27',
                'topik' => 'test 2',
                'catatan' => 'dfds',
                'status_validasi' => 'pending',
                'dibaca_oleh_dosen' => NULL,
                'dokumen_url' => NULL,
                'created_at' => '2025-06-27 12:18:00',
                'updated_at' => '2025-06-27 12:18:00',
            ),
            1 => 
            array (
                'id_bimbingan' => 5,
                'nim' => 'M2025001',
                'nidn' => 'D123456',
                'tanggal' => '2025-07-03',
                'topik' => 'sdfsdf',
                'catatan' => 'zdfsd',
                'status_validasi' => 'invalid',
                'dibaca_oleh_dosen' => NULL,
                'dokumen_url' => NULL,
                'created_at' => '2025-06-27 12:29:23',
                'updated_at' => '2025-06-27 14:13:32',
            ),
            2 => 
            array (
                'id_bimbingan' => 6,
                'nim' => 'M2025001',
                'nidn' => 'D123456',
                'tanggal' => '2025-07-05',
                'topik' => 'test timestamp',
                'catatan' => 'test timestamp',
                'status_validasi' => 'valid',
                'dibaca_oleh_dosen' => NULL,
                'dokumen_url' => NULL,
                'created_at' => '2025-06-27 12:33:14',
                'updated_at' => '2025-06-27 15:28:11',
            ),
            3 => 
            array (
                'id_bimbingan' => 7,
                'nim' => 'M2025001',
                'nidn' => 'D123456',
                'tanggal' => '2025-06-27',
                'topik' => 'paper',
                'catatan' => 'ingin menanyai soal paper',
                'status_validasi' => 'valid',
                'dibaca_oleh_dosen' => NULL,
                'dokumen_url' => NULL,
                'created_at' => '2025-06-27 15:23:31',
                'updated_at' => '2025-06-27 15:29:09',
            ),
        ));
        
        
    }
}