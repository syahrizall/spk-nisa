<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WiragaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_wiraga')->insert([
            [
                'range' => '10-50',
                'nilai' => 1,
            ],
            [
                'range' => '51-60',
                'nilai' => 2,
            ],
            [
                'range' => '61-70',
                'nilai' => 3,
            ],
            [
                'range' => '71-80',
                'nilai' => 4,
            ],
            [
                'range' => '81-100',
                'nilai' => 5,
            ]
        ]);
    }
}
