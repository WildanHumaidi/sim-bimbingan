<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DokumenTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dokumen')->delete();
        
        \DB::table('dokumen')->insert(array (
            0 => 
            array (
                'id_dokumen' => 3,
                'id_bimbingan' => 5,
                'nama_file' => '502-Article Text-2393-2-10-20240303.pdf',
                'file_path' => 'doc/1751027363_502-Article Text-2393-2-10-20240303.pdf',
                'uploaded_at' => '2025-06-27 12:29:23',
            ),
            1 => 
            array (
                'id_dokumen' => 4,
                'id_bimbingan' => 7,
                'nama_file' => '502-Article Text-2393-2-10-20240303.pdf',
                'file_path' => 'doc/1751037811_502-Article Text-2393-2-10-20240303.pdf',
                'uploaded_at' => '2025-06-27 15:23:31',
            ),
        ));
        
        
    }
}