<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengalamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_pengalaman')->insert([
            [
                'range' => '0 - 1 Lomba',
                'nilai' => 1,
            ],
            [
                'range' => '2 - 3 Lomba',
                'nilai' => 2,
            ],
            [
                'range' => '4 - 5 Lomba',
                'nilai' => 3,
            ],
            [
                'range' => '6 - 7 Lomba',
                'nilai' => 4,
            ],
            [
                'range' => '8+ Lomba',
                'nilai' => 5,
            ]
        ]);
    }
}
