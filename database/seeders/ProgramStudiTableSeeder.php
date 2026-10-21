<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProgramStudiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('program_studi')->delete();
        
        \DB::table('program_studi')->insert(array (
            0 => 
            array (
                'id_prodi' => 1,
                'nama_prodi' => 'test',
                'fakultas' => 'asd',
            ),
            1 => 
            array (
                'id_prodi' => 2,
                'nama_prodi' => 'Sistem Informasi',
                'fakultas' => 'Sistem Informasi',
            ),
        ));
        
        
    }
}