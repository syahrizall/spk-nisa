<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JumlahAnggotaKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_jumlah_anggota_keluarga')->insert([
            [
                'range' => '1 anggota keluarga',
                'nilai' => 1,
            ],
            [
                'range' => '2 anggota keluarga',
                'nilai' => 2,
            ],
            [
                'range' => '3 anggota keluarga',
                'nilai' => 3,
            ],
            [
                'range' => '4 anggota keluarga',
                'nilai' => 4,
            ],
            [
                'range' => '5 atau lebih anggota keluarga',
                'nilai' => 5,
            ]
        ]);
    }
}
