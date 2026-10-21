<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id_user' => 1,
                'username' => 'reya',
                'email' => 'admin@example.com',
                'password' => '$2y$12$3mXR/wwE8YnTpsz8F74ne.m1DDpa.di7BqSjPjkJevXBqh.dDyRlm',
                'role' => 1,
                'status_verifikasi' => 'Terverifikasi',
                'foto' => '1751110484_profile.jpg',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-28 11:34:44',
            ),
            1 => 
            array (
                'id_user' => 2,
                'username' => 'rey edit dosen test',
                'email' => 'dosen1@example.com',
                'password' => '$2y$12$3mXR/wwE8YnTpsz8F74ne.m1DDpa.di7BqSjPjkJevXBqh.dDyRlm',
                'role' => 2,
                'status_verifikasi' => 'Terverifikasi',
                'foto' => 'profile/dosen/1751033792_2x2.png',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-28 11:27:54',
            ),
            2 => 
            array (
                'id_user' => 3,
                'username' => 'mahasiswa1',
                'email' => 'mahasiswa1@example.com',
                'password' => '$2y$12$3mXR/wwE8YnTpsz8F74ne.m1DDpa.di7BqSjPjkJevXBqh.dDyRlm',
                'role' => 3,
                'status_verifikasi' => 'Terverifikasi',
                'foto' => 'mhs_3_1751030687.png',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-27 13:24:47',
            ),
            3 => 
            array (
                'id_user' => 5,
                'username' => 'test',
                'email' => 'asdas@ds.com',
                'password' => '$2y$12$8vgefKJp9U8BwaU2EWZCwu889JJLDyC0920SWBx9mbUp/IUO5y6Re',
                'role' => 3,
                'status_verifikasi' => 'Belum Terverifikasi',
                'foto' => NULL,
                'created_at' => '2025-06-28 10:47:47',
                'updated_at' => '2025-06-28 10:47:47',
            ),
            4 => 
            array (
                'id_user' => 6,
                'username' => 'testasd',
                'email' => 'asdasa@ds.com',
                'password' => '$2y$12$XIZJ6C1cv02sQIsgimVNpeFUCI7dq9R9VxvHHz/JXu3iCG.LhhPti',
                'role' => 3,
                'status_verifikasi' => 'Belum Terverifikasi',
                'foto' => NULL,
                'created_at' => '2025-06-28 10:50:08',
                'updated_at' => '2025-06-28 10:50:08',
            ),
            5 => 
            array (
                'id_user' => 7,
                'username' => 'dosen test',
                'email' => 'dosene@asd.com',
                'password' => '$2y$12$.2P7wRQYLg7FKK3BoR3jc.hwTFTz0r.Ay/lbM.SiaEVsWKi3C2hw.',
                'role' => 2,
                'status_verifikasi' => 'Belum Terverifikasi',
                'foto' => NULL,
                'created_at' => '2025-06-28 11:04:15',
                'updated_at' => '2025-06-28 11:04:15',
            ),
        ));
        
        
    }
}