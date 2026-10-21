<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Basic setup tables first
            TahunAjarTableSeeder::class,
            ProgramStudiTableSeeder::class,

            // User-related tables
            UsersTableSeeder::class,
            DosensTableSeeder::class,
            MahasiswasTableSeeder::class,

            // Then the tables that depend on users
            BimbinganTableSeeder::class,

            // Finally tables that depend on bimbingan
            DokumenTableSeeder::class,
            KomentarBimbinganTableSeeder::class,
        ]);
    }
}
