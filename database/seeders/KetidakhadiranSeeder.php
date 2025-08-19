<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KetidakhadiranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_ketidakhadiran')->insert([
            [
                'range' => '0 Hari',
                'nilai' => 5,
            ],
            [
                'range' => '1 - 2 Hari',
                'nilai' => 4,
            ],
            [
                'range' => '3 - 4 Hari',
                'nilai' => 3,
            ],
            [
                'range' => '5 - 6 Hari',
                'nilai' => 2,
            ],
            [
                'range' => '7+ Hari',
                'nilai' => 1,
            ]
        ]);
    }
}
