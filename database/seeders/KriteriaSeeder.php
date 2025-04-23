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
                'bobot' => 0.40,
            ],
            [
                'kode' => 'C2',
                'nama' => 'Wirama',
                'bobot' => 0.35,
            ],
            [
                'kode' => 'C3',
                'nama' => 'Wirasa',
                'bobot' => 0.25,
            ]
        ]);
    }
}
