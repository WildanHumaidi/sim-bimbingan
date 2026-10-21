<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DosensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dosens')->delete();
        
        \DB::table('dosens')->insert(array (
            0 => 
            array (
                'id_nidn' => '3453453232',
                'id_user' => 7,
                'nama' => 'dasdas',
                'jabatan' => 'Guru Besar',
                'fakultas' => 'Komunikasi & Bahasa',
                'created_at' => '2025-06-28 11:04:15',
                'updated_at' => '2025-06-28 11:04:15',
            ),
            1 => 
            array (
                'id_nidn' => 'D123456',
                'id_user' => 2,
                'nama' => 'Dosen Satu',
                'jabatan' => 'Lektor',
                'fakultas' => 'Teknik & Informatika',
                'created_at' => '2025-06-27 12:16:40',
                'updated_at' => '2025-06-27 12:16:40',
            ),
        ));
        
        
    }
}