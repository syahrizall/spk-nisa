<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kriteria')->insert([
            [
                'kode' => 'C1',
                'nama' => 'Tingkat Pendapatan',
                'bobot' => 0.30,
            ],
            [
                'kode' => 'C2',
                'nama' => 'Jumlah Anggota Keluarga',
                'bobot' => 0.25,
            ],
            [
                'kode' => 'C3',
                'nama' => 'Status Pekerjaan',
                'bobot' => 0.20,
            ],
            [
                'kode' => 'C4',
                'nama' => 'Kondisi Rumah',
                'bobot' => 0.15,
            ],
            [
                'kode' => 'C5',
                'nama' => 'Kondisi Kesehatan',
                'bobot' => 0.10,
            ]
        ]);
    }
}
