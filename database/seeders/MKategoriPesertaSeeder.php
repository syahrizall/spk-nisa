<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MKategoriPesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori_peserta')->insert([
            ['id' => 1, 'nama' => 'SD Kelas 1-3'],
            ['id' => 2, 'nama' => 'SD Kelas 4-6'],
            ['id' => 3, 'nama' => 'SMP/SMA'],
        ]);
    }
}
