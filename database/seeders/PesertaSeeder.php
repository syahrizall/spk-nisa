<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            "Aisyah Putri", "Ahmad Fauzan", "Budi Santoso", "Chandra Wijaya", "Dewi Lestari",
            "Eka Saputra", "Fajar Ramadhan", "Gita Anjani", "Hani Ramadhani", "Indra Gunawan",
            "Joko Susilo", "Kartini Astuti", "Lestari Wulandari", "Maya Anggraeni", "Nanda Pratama",
            "Oki Setiawan", "Putri Amalia", "Qori Nurul", "Rizki Hidayat", "Sari Dewi",
            "Toni Wahyudi", "Umar Said", "Vina Maharani", "Wawan Sugiarto", "Xena Ardiani",
            "Yogi Pratama", "Zahra Salsabila", "Bagus Wibowo", "Citra Puspitasari", "Damar Prasetyo",
            "Evi Nuraini", "Farhan Aditya", "Galuh Mahesa", "Hendra Kurniawan", "Ika Triana",
            "Juli Hartono", "Kevin Anggara", "Linda Safitri", "Mira Susanti", "Novi Yuliani",
            "Omar Hafidz", "Putu Mahendra", "Qais Alfarizi", "Rina Utami", "Sinta Maharani",
            "Taufik Fadillah", "Uli Rahmawati", "Vera Melati", "Wahyu Priyono", "Xenia Putri"
        ];

        $schools = [
            "SMAN 1 Bandung", "SMAN 2 Bandung", "SMAN 3 Bandung", "SMAN 4 Bandung", "SMAN 5 Bandung",
            "SMAN 6 Bandung", "SMAN 7 Bandung", "SMAN 8 Bandung", "SMAN 9 Bandung", "SMAN 10 Bandung",
            "Sanggar Tari Merak", "Sanggar Tari Kencana", "Sanggar Tari Nusantara", "Sanggar Tari Indah", "Sanggar Tari Gemilang",
            "Komunitas Tari Modern", "Komunitas Tari Tradisional", "Komunitas Tari Kontemporer", "Komunitas Tari Kreasi", "Komunitas Tari Inovatif"
        ];

        $data = [];
        foreach ($names as $name) {
            $gender = rand(0, 1) ? 'Laki-laki' : 'Perempuan';
            $birthDate = date('Y-m-d', strtotime('-' . rand(15, 25) . ' years'));
            
            // Generate nilai yang sesuai dengan tabel referensi (1-5)
            $wiraga = rand(50, 97);        // Range 1-5 sesuai tabel referensi
            $wirama = rand(50, 97);        // Range 1-5 sesuai tabel referensi
            $wirasa = rand(50, 97);        // Range 1-5 sesuai tabel referensi
            $pengalaman = rand(0, 8);    // 0-8 lomba (nilai langsung)
            $ketidakhadiran = rand(0, 15); // 0-15 hari tidak hadir (nilai langsung)
            
            $data[] = [
                'nama_lengkap' => $name,
                'jenis_kelamin' => $gender,
                'tanggal_lahir' => $birthDate,
                'asal_sekolah' => $schools[array_rand($schools)],
                'nomor_hp' => '08' . rand(1000000000, 9999999999),
                'wiraga' => $wiraga,           // ID dari tabel referensi (1-5)
                'wirama' => $wirama,           // ID dari tabel referensi (1-5)
                'wirasa' => $wirasa,           // ID dari tabel referensi (1-5)
                'kategori_peserta_id' => rand(1, 3),
                'pengalaman' => $pengalaman,   // Nilai langsung (0-8)
                'ketidakhadiran' => $ketidakhadiran, // Nilai langsung (0-15)
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('m_peserta')->insert($data);
    }
}
