<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenerimaSeeder extends Seeder
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
            "Taufik Fadillah", "Uli Rahmawati", "Vera Melati", "Wahyu Priyono", "Xenia Putri",
            "Yusuf Hidayat", "Zaskia Adinda", "Arif Kurniawan", "Benny Setiawan", "Cindy Marlina",
            "Deni Kurniawan", "Elisa Anggraini", "Faisal Ahmad", "Gilang Ramadhan", "Haris Firmansyah",
            "Intan Permata", "Junaedi Wahyu", "Karina Maharani", "Lina Suharto", "Mukti Anwar",
            "Nina Aprilia", "Olivia Prasetyo", "Pandu Wicaksono", "Qonita Ayu", "Rudi Santoso",
            "Sari Pratiwi", "Tania Fitri", "Umar Alamsyah", "Vicky Rinaldi", "Winda Lestari",
            "Yuli Agustin", "Zidan Hakim", "Andi Wijaya", "Bella Safira", "Cahya Ramadhani",
            "Dewi Anggraeni", "Eko Prasetyo", "Fauzi Kurniawan", "Ghea Putri", "Hendri Setiawan",
            "Ilham Maulana", "Jihan Safitri", "Kurniawan Aditya", "Lia Ramadhani", "Mutiara Sari",
            "Novi Susanto", "Ovi Yuliani", "Pramono Tri", "Qonita Maharani", "Rizal Fadillah",
            "Siti Nurhaliza", "Tedi Suharto", "Umi Kalsum", "Valen Hartono", "Widi Susilo"
        ];

        $data = [];
        foreach ($names as $name) {
            $data[] = [
                'nama' => $name,
                'alamat' => 'Jl. Maleber, No. ' . rand(1, 100),
                'no_kk' => rand(1000000000000000, 9999999999999999),
                'nik' => rand(1000000000000000, 9999999999999999),
                'no_telpon' => '08' . rand(1000000000, 9999999999),
                'tingkat_pendapatan' => rand(1, 5),
                'jumlah_anggota_keluarga' => rand(1, 5),
                'status_pekerjaan' => rand(1, 5),
                'kondisi_rumah' => rand(1, 5),
                'kondisi_kesehatan' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('m_penerima')->insert($data);
    }
}
