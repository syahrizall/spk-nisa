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
                'nama' => 'Wiraga',
                'bobot' => 0.25,
                'vektor' => 'v',
                'keterangan' => 'Kemampuan gerak tubuh dan fisik (Benefit)',
            ],
            [
                'kode' => 'C2',
                'nama' => 'Wirama',
                'bobot' => 0.20,
                'vektor' => 'v',
                'keterangan' => 'Kemampuan ritme dan musik (Benefit)',
            ],
            [
                'kode' => 'C3',
                'nama' => 'Wirasa',
                'bobot' => 0.15,
                'vektor' => 'v',
                'keterangan' => 'Kemampuan ekspresi dan perasaan (Benefit)',
            ],
            [
                'kode' => 'C4',
                'nama' => 'Pengalaman',
                'bobot' => 0.25,
                'vektor' => 'v',
                'keterangan' => 'Pengalaman mengikuti lomba dan prestasi (Benefit)',
            ],
            [
                'kode' => 'C5',
                'nama' => 'Ketidakhadiran',
                'bobot' => 0.15,
                'vektor' => 's',
                'keterangan' => 'Jumlah ketidakhadiran dalam latihan (Cost)',
            ]
        ]);
    }
}
