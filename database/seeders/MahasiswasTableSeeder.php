<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MahasiswasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mahasiswas')->delete();
        
        \DB::table('mahasiswas')->insert(array (
            0 => 
            array (
                'id_nim' => '1222332211',
                'id_user' => 5,
                'nama' => 'asdasd',
                'program_studi' => 'teknik sipil',
                'angkatan' => '2021',
                'created_at' => '2025-06-28 10:47:47',
                'updated_at' => '2025-06-28 10:47:47',
            ),
            1 => 
            array (
                'id_nim' => '1222332213',
                'id_user' => 6,
                'nama' => 'asdasds',
                'program_studi' => 'teknik sipila',
                'angkatan' => '2021',
                'created_at' => '2025-06-28 10:50:08',
                'updated_at' => '2025-06-28 10:50:08',
            ),
            2 => 
            array (
                'id_nim' => 'M2025001',
                'id_user' => 3,
                'nama' => 'Mahasiswa Satua',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => '2025',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-27 13:23:02',
            ),
        ));
        
        
    }
}