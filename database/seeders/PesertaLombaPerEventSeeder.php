<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PesertaLombaPerEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua event yang sudah ada
        $events = DB::table('m_event')->get();
        
        // Ambil semua peserta
        $peserta = DB::table('m_peserta')->get();
        
        $data = [];
        
        foreach ($events as $event) {
            // Tentukan berapa peserta yang akan diikutkan (sesuai kuota)
            $pesertaCount = min($event->kuota, $peserta->count());
            
            // Ambil peserta secara random untuk event ini
            $selectedPeserta = $peserta->random($pesertaCount);
            
            foreach ($selectedPeserta as $p) {
                $data[] = [
                    'event_id' => $event->id,
                    'peserta_id' => $p->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        if (!empty($data)) {
            DB::table('t_peserta_lomba_per_event')->insert($data);
        }
    }
}
