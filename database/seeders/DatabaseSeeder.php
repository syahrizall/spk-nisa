<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\KriteriaSeeder;
use Database\Seeders\PenerimaSeeder;
use Database\Seeders\KondisiRumahSeeder;
use Database\Seeders\StatusPekerjaanSeeder;
use Database\Seeders\KondisiKesehatanSeeder;
use Database\Seeders\TingkatPendapatanSeeder;
use Database\Seeders\JumlahAnggotaKeluargaSeeder;

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
            KriteriaSeeder::class,
            UserSeeder::class,
            JumlahAnggotaKeluargaSeeder::class,
            KondisiKesehatanSeeder::class,
            KondisiRumahSeeder::class,
            StatusPekerjaanSeeder::class,
            TingkatPendapatanSeeder::class,
            PenerimaSeeder::class,
            JumlahPenerimaSeeder::class,
            // Tambahkan Seeder lainnya di sini
        ]);
    }
}
