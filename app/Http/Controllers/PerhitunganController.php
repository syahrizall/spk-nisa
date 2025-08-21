<?php

namespace App\Http\Controllers;

use App\Models\DataAlternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function indexAlternatif()
    {
        $data = DB::table('t_data_alternatif')
            ->select(
                't_data_alternatif.*',
                'm_peserta.nama_lengkap as nama_peserta',
                'm_kategori_peserta.id as kategori_id',
                'm_kategori_peserta.nama as kategori_peserta'
            )
            ->join('m_peserta', 't_data_alternatif.peserta_id', '=', 'm_peserta.id')
            ->join('m_kategori_peserta', 'm_peserta.kategori_peserta_id', '=', 'm_kategori_peserta.id')
            ->orderBy('m_kategori_peserta.nama', 'ASC')
            ->orderBy('m_peserta.nama_lengkap', 'ASC')
            ->get()
            ->groupBy('kategori_peserta'); // ✅ Grouping by nama kategori

        return view('dashboard.data-alternatif.index', compact('data'));
    }


    public function indexRanking()
    {
        $rawData = DB::table('t_nilai_akhir')
            ->select('t_nilai_akhir.*', 'm_peserta.nama_lengkap as nama_peserta', 'm_kategori_peserta.nama as kategori_peserta')
            ->join('m_peserta', 't_nilai_akhir.peserta_id', '=', 'm_peserta.id')
            ->join('m_kategori_peserta', 'm_peserta.kategori_peserta_id', '=', 'm_kategori_peserta.id')
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->get();

        $data = $rawData->groupBy('kategori_peserta');
        return view('dashboard.data-ranking.index', compact('data'));
    }


    public function refreshRanking()
    {
        // Menghapus semua data perhitungan
        DataAlternatif::truncate();
        NilaiAkhir::truncate();

        // 1. Ambil semua data yang diperlukan dalam 1 query
        $bobot = Kriteria::pluck('bobot', 'nama');
        $peserta = Peserta::all();
        
        // 2. Hitung nilai maksimal dan minimal dari nilai yang sudah dikonversi
        $maxValues = $this->getMaxValues();
        $minValues = $this->getMinValues();
        $vektorKriteria = $this->getVektorKriteria();
        
        // 3. Siapkan array untuk batch insert
        $dataAlternatifBatch = [];
        $nilaiAkhirBatch = [];

        // 4. Loop sekali untuk semua perhitungan
        foreach ($peserta as $data) {
            // Hitung data alternatif
            $alternatifData = $this->calculateDataAlternatifData($data, $bobot, $maxValues, $minValues, $vektorKriteria);
            $dataAlternatifBatch[] = $alternatifData;
            
            // Hitung nilai akhir
            $nilaiAkhirData = $this->calculateNilaiAkhirData($data, $bobot, $maxValues, $minValues, $vektorKriteria);
            $nilaiAkhirBatch[] = $nilaiAkhirData;
        }

        // 5. Batch insert untuk performa lebih baik
        if (!empty($dataAlternatifBatch)) {
            DataAlternatif::insert($dataAlternatifBatch);
        }
        
        if (!empty($nilaiAkhirBatch)) {
            NilaiAkhir::insert($nilaiAkhirBatch);
        }

        return redirect('/data-ranking')->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Method helper untuk konversi nilai dari tabel referensi ke nilai sebenarnya
     * Mencari nilai berdasarkan range yang sesuai
     */
    private function convertReferenceValue($inputValue, $tableName)
    {
        // Ambil semua range dari tabel referensi
        $ranges = DB::table($tableName)->get(['range', 'nilai']);
        
        // Cari range yang sesuai dengan input value
        foreach ($ranges as $range) {
            list($min, $max) = explode('-', $range->range);
            if ($inputValue >= $min && $inputValue <= $max) {
                return $range->nilai;
            }
        }
        
        return 0; // Return 0 jika tidak ditemukan range yang sesuai
    }

    /**
     * Method helper untuk mendapatkan nilai maksimal setiap kriteria
     * Nilai sudah dikonversi dari tabel referensi
     */
    private function getMaxValues()
    {
        $peserta = Peserta::all();
        $maxValues = [
            'Wiraga' => 0,
            'Wirama' => 0,
            'Wirasa' => 0,
            'Pengalaman' => 0,
            'Ketidakhadiran' => 0
        ];

        foreach ($peserta as $p) {
            // Konversi nilai dari tabel referensi
            $wiragaValue = $this->convertReferenceValue($p->wiraga, 'm_wiraga');
            $wiramaValue = $this->convertReferenceValue($p->wirama, 'm_wirama');
            $wirasaValue = $this->convertReferenceValue($p->wirasa, 'm_wirasa');
            
            // Update max values
            $maxValues['Wiraga'] = max($maxValues['Wiraga'], $wiragaValue);
            $maxValues['Wirama'] = max($maxValues['Wirama'], $wiramaValue);
            $maxValues['Wirasa'] = max($maxValues['Wirasa'], $wirasaValue);
            $maxValues['Pengalaman'] = max($maxValues['Pengalaman'], $p->pengalaman);
            $maxValues['Ketidakhadiran'] = max($maxValues['Ketidakhadiran'], $p->ketidakhadiran);
        }

        return $maxValues;
    }

    /**
     * Method helper untuk mendapatkan nilai minimal setiap kriteria
     * Untuk kriteria cost (vektor s)
     */
    private function getMinValues()
    {
        $peserta = Peserta::all();
        $minValues = [
            'Wiraga' => PHP_FLOAT_MAX,
            'Wirama' => PHP_FLOAT_MAX,
            'Wirasa' => PHP_FLOAT_MAX,
            'Pengalaman' => PHP_FLOAT_MAX,
            'Ketidakhadiran' => PHP_FLOAT_MAX
        ];

        foreach ($peserta as $p) {
            // Konversi nilai dari tabel referensi
            $wiragaValue = $this->convertReferenceValue($p->wiraga, 'm_wiraga');
            $wiramaValue = $this->convertReferenceValue($p->wirama, 'm_wirama');
            $wirasaValue = $this->convertReferenceValue($p->wirasa, 'm_wirasa');
            
            // Update min values
            $minValues['Wiraga'] = min($minValues['Wiraga'], $wiragaValue);
            $minValues['Wirama'] = min($minValues['Wirama'], $wiramaValue);
            $minValues['Wirasa'] = min($minValues['Wirasa'], $wirasaValue);
            $minValues['Pengalaman'] = min($minValues['Pengalaman'], $p->pengalaman);
            $minValues['Ketidakhadiran'] = min($minValues['Ketidakhadiran'], $p->ketidakhadiran);
        }

        return $minValues;
    }

    /**
     * Method helper untuk mendapatkan vektor setiap kriteria
     */
    private function getVektorKriteria()
    {
        $kriteria = Kriteria::pluck('vektor', 'nama');
        return $kriteria;
    }

    /**
     * Method helper untuk normalisasi nilai kriteria
     * Menangani vektor v (benefit) dan vektor s (cost)
     */
    private function normalizeValue($value, $maxValue, $minValue, $vektor)
    {
        if ($vektor == 'v') {
            // Vektor v (Benefit): semakin tinggi semakin baik
            // Rumus: xij / max_xj
            return $maxValue > 0 ? $value / $maxValue : 0;
        } else {
            // Vektor s (Cost): semakin rendah semakin baik
            // Rumus: min_xj / xij
            // Handle division by zero dengan cara yang lebih baik
            if ($value <= 0) {
                // Jika nilai peserta = 0, set ke nilai minimal yang valid
                $value = 1;
            }
            if ($minValue <= 0) {
                // Jika min value = 0, cari nilai minimal yang valid
                $minValue = 1;
            }
            return $minValue / $value;
        }
    }

    /**
     * Method untuk menghitung data alternatif (tanpa save)
     * Mengembalikan array data untuk batch insert
     */
    private function calculateDataAlternatifData($data, $bobot, $maxValues, $minValues, $vektorKriteria)
    {
        // Konversi nilai dari tabel referensi
        $wiragaValue = $this->convertReferenceValue($data->wiraga, 'm_wiraga');
        $wiramaValue = $this->convertReferenceValue($data->wirama, 'm_wirama');
        $wirasaValue = $this->convertReferenceValue($data->wirasa, 'm_wirasa');
        
        // Normalisasi dan pangkatkan dengan bobot sesuai rumus WP
        // Rumus: (xij/max_xj)^wj untuk benefit, (min_xj/xij)^wj untuk cost
        
        $wiraga = pow($this->normalizeValue($wiragaValue, $maxValues['Wiraga'], $minValues['Wiraga'], $vektorKriteria['Wiraga']), $bobot['Wiraga']);
        $wirama = pow($this->normalizeValue($wiramaValue, $maxValues['Wirama'], $minValues['Wirama'], $vektorKriteria['Wirama']), $bobot['Wirama']);
        $wirasa = pow($this->normalizeValue($wirasaValue, $maxValues['Wirasa'], $minValues['Wirasa'], $vektorKriteria['Wirasa']), $bobot['Wirasa']);
        $pengalaman = pow($this->normalizeValue($data->pengalaman, $maxValues['Pengalaman'], $minValues['Pengalaman'], $vektorKriteria['Pengalaman']), $bobot['Pengalaman']);
        $ketidakhadiran = pow($this->normalizeValue($data->ketidakhadiran, $maxValues['Ketidakhadiran'], $minValues['Ketidakhadiran'], $vektorKriteria['Ketidakhadiran']), $bobot['Ketidakhadiran']);
        
        return [
            'peserta_id' => $data->id,
            'wiraga' => $wiraga,
            'wirama' => $wirama,
            'wirasa' => $wirasa,
            'pengalaman' => $pengalaman,
            'ketidakhadiran' => $ketidakhadiran,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    /**
     * Method untuk menghitung nilai akhir (tanpa save)
     * Mengembalikan array data untuk batch insert
     */
    private function calculateNilaiAkhirData($data, $bobot, $maxValues, $minValues, $vektorKriteria)
    {
        // Konversi nilai dari tabel referensi
        $wiragaValue = $this->convertReferenceValue($data->wiraga, 'm_wiraga');
        $wiramaValue = $this->convertReferenceValue($data->wirama, 'm_wirama');
        $wirasaValue = $this->convertReferenceValue($data->wirasa, 'm_wirasa');
        
        // Normalisasi dan pangkatkan sesuai rumus WP
        $wiraga = pow($this->normalizeValue($wiragaValue, $maxValues['Wiraga'], $minValues['Wiraga'], $vektorKriteria['Wiraga']), $bobot['Wiraga']);
        $wirama = pow($this->normalizeValue($wiramaValue, $maxValues['Wirama'], $minValues['Wirama'], $vektorKriteria['Wirama']), $bobot['Wirama']);
        $wirasa = pow($this->normalizeValue($wirasaValue, $maxValues['Wirasa'], $minValues['Wirasa'], $vektorKriteria['Wirasa']), $bobot['Wirasa']);
        $pengalaman = pow($this->normalizeValue($data->pengalaman, $maxValues['Pengalaman'], $minValues['Pengalaman'], $vektorKriteria['Pengalaman']), $bobot['Pengalaman']);
        $ketidakhadiran = pow($this->normalizeValue($data->ketidakhadiran, $maxValues['Ketidakhadiran'], $minValues['Ketidakhadiran'], $vektorKriteria['Ketidakhadiran']), $bobot['Ketidakhadiran']);
        
        // Hitung nilai akhir dengan perkalian semua kriteria
        // Rumus: S = ∏(xij_normalized)^wj
        $nilai_akhir = $wiraga * $wirama * $wirasa * $pengalaman * $ketidakhadiran;
        
        return [
            'peserta_id' => $data->id,
            'wiraga' => $wiraga,
            'wirama' => $wirama,
            'wirasa' => $wirasa,
            'pengalaman' => $pengalaman,
            'ketidakhadiran' => $ketidakhadiran,
            'nilai_akhir' => $nilai_akhir,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    // Method lama tetap ada untuk backward compatibility (bisa dihapus nanti)
    private function calculateDataAlternatif($data, $bobot)
    {
        $maxValues = $this->getMaxValues();
        $minValues = $this->getMinValues();
        $vektorKriteria = $this->getVektorKriteria();
        
        $data_alternatif = new DataAlternatif();
        $data_alternatif->peserta_id = $data->id;
        
        // Konversi nilai dari tabel referensi
        $wiragaValue = $this->convertReferenceValue($data->wiraga, 'm_wiraga');
        $wiramaValue = $this->convertReferenceValue($data->wirama, 'm_wirama');
        $wirasaValue = $this->convertReferenceValue($data->wirasa, 'm_wirasa');
        
        // Normalisasi dan pangkatkan dengan bobot sesuai rumus WP
        // Rumus: (xij/max_xj)^wj untuk benefit, (min_xj/xij)^wj untuk cost
        $data_alternatif->wiraga = pow($this->normalizeValue($wiragaValue, $maxValues['Wiraga'], $minValues['Wiraga'], $vektorKriteria['Wiraga']), $bobot['Wiraga']);
        $data_alternatif->wirama = pow($this->normalizeValue($wiramaValue, $maxValues['Wirama'], $minValues['Wirama'], $vektorKriteria['Wirama']), $bobot['Wirama']);
        $data_alternatif->wirasa = pow($this->normalizeValue($wirasaValue, $maxValues['Wirasa'], $minValues['Wirasa'], $vektorKriteria['Wirasa']), $bobot['Wirasa']);
        $data_alternatif->pengalaman = pow($this->normalizeValue($data->pengalaman, $maxValues['Pengalaman'], $minValues['Pengalaman'], $vektorKriteria['Pengalaman']), $bobot['Pengalaman']);
        $data_alternatif->ketidakhadiran = pow($this->normalizeValue($data->ketidakhadiran, $maxValues['Ketidakhadiran'], $minValues['Ketidakhadiran'], $vektorKriteria['Ketidakhadiran']), $bobot['Ketidakhadiran']);
        
        $data_alternatif->save();
    }

    private function calculateNilaiAkhir($row, $bobot)
    {
        $maxValues = $this->getMaxValues();
        $minValues = $this->getMinValues();
        $vektorKriteria = $this->getVektorKriteria();
        
        $nilai_akhir = new NilaiAkhir();
        $nilai_akhir->peserta_id = $row->id;
        
        // Konversi nilai dari tabel referensi
        $wiragaValue = $this->convertReferenceValue($row->wiraga, 'm_wiraga');
        $wiramaValue = $this->convertReferenceValue($row->wirama, 'm_wirama');
        $wirasaValue = $this->convertReferenceValue($row->wirasa, 'm_wirasa');
        
        // Normalisasi dan pangkatkan sesuai rumus WP
        $nilai_akhir->wiraga = pow($this->normalizeValue($wiragaValue, $maxValues['Wiraga'], $minValues['Wiraga'], $vektorKriteria['Wiraga']), $bobot['Wiraga']);
        $nilai_akhir->wirama = pow($this->normalizeValue($wiramaValue, $maxValues['Wirama'], $minValues['Wirama'], $vektorKriteria['Wirama']), $bobot['Wirama']);
        $nilai_akhir->wirasa = pow($this->normalizeValue($wirasaValue, $maxValues['Wirasa'], $minValues['Wirasa'], $vektorKriteria['Wirasa']), $bobot['Wirasa']);
        $nilai_akhir->pengalaman = pow($this->normalizeValue($row->pengalaman, $maxValues['Pengalaman'], $minValues['Pengalaman'], $vektorKriteria['Pengalaman']), $bobot['Pengalaman']);
        $nilai_akhir->ketidakhadiran = pow($this->normalizeValue($row->ketidakhadiran, $maxValues['Ketidakhadiran'], $minValues['Ketidakhadiran'], $vektorKriteria['Ketidakhadiran']), $bobot['Ketidakhadiran']);
        
        // Hitung nilai akhir
        $nilai_akhir->nilai_akhir = $nilai_akhir->wiraga * $nilai_akhir->wirama * $nilai_akhir->wirasa * $nilai_akhir->pengalaman * $nilai_akhir->ketidakhadiran;
        
        $nilai_akhir->save();
    }
}