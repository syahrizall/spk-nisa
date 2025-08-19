<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'nama' => 'Festival Tari Nusantara 2025',
                'kuota' => 7,
                'tanggal' => '2025-08-15',
                'kategori_peserta_id' => 3, // SMP/SMA
                'status' => 'selesai',
                'deskripsi' => 'Festival tari tradisional tingkat provinsi untuk kategori SMP/SMA',
                'lokasi' => 'Gedung Kesenian Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Festival Tari Kreasi 2025',
                'kuota' => 5,
                'tanggal' => '2025-12-15',
                'kategori_peserta_id' => 2, // SD Kelas 4-6
                'status' => 'aktif',
                'deskripsi' => 'Festival tari kreasi dengan tema kebudayaan modern',
                'lokasi' => 'Plaza Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_event')->insert($events);
    }
}
