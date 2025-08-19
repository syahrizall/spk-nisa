<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SamplePesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data sample peserta yang lebih realistis
        $sampleData = [
            [
                'nama_lengkap' => 'Aisyah Putri',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2008-03-15',
                'asal_sekolah' => 'SMAN 1 Bandung',
                'nomor_hp' => '081234567890',
                'wiraga' => 85.50,
                'wirama' => 88.75,
                'wirasa' => 90.25,
                'kategori_peserta_id' => 3, // SMP/SMA
                'pengalaman' => 5,
                'ketidakhadiran' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Ahmad Fauzan',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2009-07-22',
                'asal_sekolah' => 'SMAN 2 Bandung',
                'nomor_hp' => '081234567891',
                'wiraga' => 78.25,
                'wirama' => 82.50,
                'wirasa' => 85.75,
                'kategori_peserta_id' => 3, // SMP/SMA
                'pengalaman' => 3,
                'ketidakhadiran' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2010-11-08',
                'asal_sekolah' => 'SDN 1 Bandung',
                'nomor_hp' => '081234567892',
                'wiraga' => 72.00,
                'wirama' => 75.50,
                'wirasa' => 78.25,
                'kategori_peserta_id' => 2, // SD Kelas 4-6
                'pengalaman' => 2,
                'ketidakhadiran' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Dewi Lestari',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2011-05-12',
                'asal_sekolah' => 'SDN 2 Bandung',
                'nomor_hp' => '081234567893',
                'wiraga' => 68.75,
                'wirama' => 71.25,
                'wirasa' => 73.50,
                'kategori_peserta_id' => 1, // SD Kelas 1-3
                'pengalaman' => 1,
                'ketidakhadiran' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Eka Saputra',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2008-09-30',
                'asal_sekolah' => 'Sanggar Tari Merak',
                'nomor_hp' => '081234567894',
                'wiraga' => 92.50,
                'wirama' => 95.25,
                'wirasa' => 93.75,
                'kategori_peserta_id' => 3, // SMP/SMA
                'pengalaman' => 8,
                'ketidakhadiran' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Fajar Ramadhan',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2009-12-03',
                'asal_sekolah' => 'Sanggar Tari Kencana',
                'nomor_hp' => '081234567895',
                'wiraga' => 88.00,
                'wirama' => 91.50,
                'wirasa' => 89.25,
                'kategori_peserta_id' => 3, // SMP/SMA
                'pengalaman' => 6,
                'ketidakhadiran' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Gita Anjani',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2010-02-18',
                'asal_sekolah' => 'SDN 3 Bandung',
                'nomor_hp' => '081234567896',
                'wiraga' => 75.25,
                'wirama' => 78.75,
                'wirasa' => 80.50,
                'kategori_peserta_id' => 2, // SD Kelas 4-6
                'pengalaman' => 4,
                'ketidakhadiran' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Hani Ramadhani',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2011-08-25',
                'asal_sekolah' => 'SDN 4 Bandung',
                'nomor_hp' => '081234567897',
                'wiraga' => 65.50,
                'wirama' => 68.25,
                'wirasa' => 70.00,
                'kategori_peserta_id' => 1, // SD Kelas 1-3
                'pengalaman' => 0,
                'ketidakhadiran' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Indra Gunawan',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2008-01-10',
                'asal_sekolah' => 'Komunitas Tari Modern',
                'nomor_hp' => '081234567898',
                'wiraga' => 90.75,
                'wirama' => 87.50,
                'wirasa' => 92.00,
                'kategori_peserta_id' => 3, // SMP/SMA
                'pengalaman' => 7,
                'ketidakhadiran' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Joko Susilo',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2009-06-14',
                'asal_sekolah' => 'Komunitas Tari Tradisional',
                'nomor_hp' => '081234567899',
                'wiraga' => 82.25,
                'wirama' => 85.75,
                'wirasa' => 88.50,
                'kategori_peserta_id' => 3, // SMP/SMA
                'pengalaman' => 4,
                'ketidakhadiran' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('m_peserta')->insert($sampleData);
    }
}
