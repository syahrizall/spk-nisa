<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KondisiRumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kondisi_rumah')->insert([
            [
                'range' => 'Rumah permanen, kondisi baik',
                'nilai' => 1,
            ],
            [
                'range' => 'Rumah semi permanen, kondisi baik',
                'nilai' => 2,
            ],
            [
                'range' => 'Rumah semi permanen, kondisi kurang baik',
                'nilai' => 3,
            ],
            [
                'range' => 'Rumah tidak permanen, kondisi kurang baik',
                'nilai' => 4,
            ],
            [
                'range' => 'Rumah sangat sederhana, kondisi buruk',
                'nilai' => 5,
            ]
        ]);
    }
}
