<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TingkatPendapatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_tingkat_pendapatan')->insert([
            [
                'range' => 'Lebih dari Rp 4.000.000 per bulan',
                'nilai' => 1,
            ],
            [
                'range' => 'Rp 3.000.000 - Rp 4.000.000 per bulan',
                'nilai' => 2,
            ],
            [
                'range' => 'Rp 2.000.000 - Rp 3.000.000 per bulan',
                'nilai' => 3,
            ],
            [
                'range' => 'Rp 1.000.000 - Rp 2.000.000 per bulan',
                'nilai' => 4,
            ],
            [
                'range' => 'Kurang dari Rp 1.000.000 per bulan',
                'nilai' => 5,
            ]
        ]);
    }
}
