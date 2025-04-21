<?php

namespace App\Http\Controllers;

use App\Models\DataAlternatif;
use App\Models\Kriteria;
use App\Models\NilaiAkhir;
use App\Models\Penerima;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function indexAlternatif()
    {
        $data = DB::table('t_data_alternatif')
        ->select('t_data_alternatif.*', 'm_penerima.nama as nama_penerima')
        ->join('m_penerima', 't_data_alternatif.penerima_id', '=', 'm_penerima.id')
        ->orderBy('m_penerima.nama', 'ASC')
        ->get();
        return view('dashboard.data-alternatif.index', compact('data'));
    }

    public function indexRanking()
    {
        $data = DB::table('t_nilai_akhir')
        ->select('t_nilai_akhir.*', 'm_penerima.nama as nama_penerima')
        ->join('m_penerima', 't_nilai_akhir.penerima_id', '=', 'm_penerima.id')
        ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
        ->get();
        return view('dashboard.data-ranking.index', compact('data'));
    }

    public function refreshRanking()
    {
        // Menghapus semua data perhitungan
        DataAlternatif::truncate();
        NilaiAkhir::truncate();

        // Mencari nilai maksimal dari masing-masing kriteria
        $bobot = Kriteria::pluck('bobot', 'nama');

        $penerima = Penerima::all();

        // Rumus pangkatkan kriteria dengan bobot
        foreach ($penerima as $data) {
            $this->calculateDataAlternatif($data, $bobot);
        }

        foreach ($penerima as $row) {
            $this->calculateNilaiAkhir($row, $bobot);
        }

        return redirect('/data-ranking')->with('message', 'Data Berhasil Di Update');
    }

    private function calculateDataAlternatif($data, $bobot)
    {
        $data_alternatif = new DataAlternatif();
        $data_alternatif->penerima_id = $data->id;
        $data_alternatif->tingkat_pendapatan = pow($data->tingkat_pendapatan, $bobot['Tingkat Pendapatan']);
        $data_alternatif->jumlah_anggota_keluarga = pow($data->jumlah_anggota_keluarga, $bobot['Jumlah Anggota Keluarga']);
        $data_alternatif->status_pekerjaan = pow($data->status_pekerjaan, $bobot['Status Pekerjaan']);
        $data_alternatif->kondisi_rumah = pow($data->kondisi_rumah, $bobot['Kondisi Rumah']);
        $data_alternatif->kondisi_kesehatan = pow($data->kondisi_kesehatan, $bobot['Kondisi Kesehatan']);
        $data_alternatif->save();
    }

    private function calculateNilaiAkhir($row, $bobot)
    {
        $nilai_akhir = new NilaiAkhir();
        $nilai_akhir->penerima_id = $row->id;
        $nilai_akhir->tingkat_pendapatan = pow($row->tingkat_pendapatan, $bobot['Tingkat Pendapatan']);
        $nilai_akhir->jumlah_anggota_keluarga = pow($row->jumlah_anggota_keluarga, $bobot['Jumlah Anggota Keluarga']);
        $nilai_akhir->status_pekerjaan = pow($row->status_pekerjaan, $bobot['Status Pekerjaan']);
        $nilai_akhir->kondisi_rumah = pow($row->kondisi_rumah, $bobot['Kondisi Rumah']);
        $nilai_akhir->kondisi_kesehatan = pow($row->kondisi_kesehatan, $bobot['Kondisi Kesehatan']);
        $nilai_akhir->nilai_akhir = $nilai_akhir->tingkat_pendapatan *
            $nilai_akhir->jumlah_anggota_keluarga *
            $nilai_akhir->status_pekerjaan *
            $nilai_akhir->kondisi_rumah *
            $nilai_akhir->kondisi_kesehatan;
        $nilai_akhir->save();
    }
}