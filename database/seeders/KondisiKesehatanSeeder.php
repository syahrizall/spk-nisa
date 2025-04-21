<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KondisiKesehatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kondisi_kesehatan')->insert([
            [
                'range' => 'Semua anggota keluarga sehat',
                'nilai' => 1,
            ],
            [
                'range' => 'Ada anggota keluarga dengan penyakit ringan',
                'nilai' => 2,
            ],
            [
                'range' => 'Ada anggota keluarga dengan penyakit sedang',
                'nilai' => 3,
            ],
            [
                'range' => 'Ada anggota keluarga dengan penyakit berat',
                'nilai' => 4,
            ],
            [
                'range' => 'Ada anggota keluarga dengan penyakit kronis atau disabilitas',
                'nilai' => 5,
            ]
        ]);
    }
}
