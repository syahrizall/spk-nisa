<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // Seeder untuk master data
            MKategoriPesertaSeeder::class,
            KriteriaSeeder::class,
            
            // Seeder untuk referensi nilai kriteria (diperlukan untuk perhitungan)
            WiragaSeeder::class,
            WiramaSeeder::class,
            WirasaSeeder::class,
            PengalamanSeeder::class,
            KetidakhadiranSeeder::class,
            
            // Seeder untuk user dan data awal
            UserSeeder::class,
            JumlahPesertaSeeder::class,
            
            // Seeder untuk data peserta (50 data random)
            PesertaSeeder::class,
            
            // Seeder untuk event dan peserta lomba
            EventSeeder::class,
            PesertaLombaPerEventSeeder::class,
            
            // Catatan: Seeder Wiraga, Wirama, Wirasa tetap diperlukan
            // untuk konversi nilai input ke range yang sesuai saat perhitungan
        ]);
    }
}
