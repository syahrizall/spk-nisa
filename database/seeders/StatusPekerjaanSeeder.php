<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusPekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_status_pekerjaan')->insert([
            [
                'range' => 'Pekerja tetap',
                'nilai' => 1,
            ],
            [
                'range' => 'Pekerja kontrak',
                'nilai' => 2,
            ],
            [
                'range' => 'Pekerja harian lepas',
                'nilai' => 3,
            ],
            [
                'range' => 'Tidak bekerja (menganggur)',
                'nilai' => 4,
            ],
            [
                'range' => 'Tidak bekerja dan memiliki tanggungan',
                'nilai' => 5,
            ]
        ]);
    }
}
