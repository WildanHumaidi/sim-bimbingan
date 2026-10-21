<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TahunAjarTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tahun_ajar')->delete();
        
        \DB::table('tahun_ajar')->insert(array (
            0 => 
            array (
                'id_tahun' => 3,
                'tahun' => '2025',
                'semester' => 'Ganjil',
            ),
            1 => 
            array (
                'id_tahun' => 4,
                'tahun' => '2024',
                'semester' => 'Ganjil',
            ),
        ));
        
        
    }
}