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
        ->select('t_data_alternatif.*', 'm_peserta.nama_lengkap as nama_peserta')
        ->join('m_peserta', 't_data_alternatif.peserta_id', '=', 'm_peserta.id')
        ->orderBy('m_peserta.nama_lengkap', 'ASC')
        ->get();
        return view('dashboard.data-alternatif.index', compact('data'));
    }

    public function indexRanking()
    {
        $data = DB::table('t_nilai_akhir')
        ->select('t_nilai_akhir.*', 'm_peserta.nama_lengkap as nama_peserta')
        ->join('m_peserta', 't_nilai_akhir.peserta_id', '=', 'm_peserta.id')
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

        $peserta = Peserta::all();

        // Rumus pangkatkan kriteria dengan bobot
        foreach ($peserta as $data) {
            $this->calculateDataAlternatif($data, $bobot);
        }

        foreach ($peserta as $row) {
            $this->calculateNilaiAkhir($row, $bobot);
        }

        return redirect('/data-ranking')->with('message', 'Data Berhasil Di Update');
    }

    private function calculateDataAlternatif($data, $bobot)
    {
        $data_alternatif = new DataAlternatif();
        $data_alternatif->peserta_id = $data->id;
        $data_alternatif->wiraga = pow($data->wiraga, $bobot['Wiraga']);
        $data_alternatif->wirama = pow($data->wirama, $bobot['Wirama']);
        $data_alternatif->wirasa = pow($data->wirasa, $bobot['Wirasa']);
        $data_alternatif->save();
    }

    private function calculateNilaiAkhir($row, $bobot)
    {
        $nilai_akhir = new NilaiAkhir();
        $nilai_akhir->peserta_id = $row->id;
        $nilai_akhir->wiraga = pow($row->wiraga, $bobot['Wiraga']);
        $nilai_akhir->wirama = pow($row->wirama, $bobot['Wirama']);
        $nilai_akhir->wirasa = pow($row->wirasa, $bobot['Wirasa']);
        $nilai_akhir->nilai_akhir = $nilai_akhir->wiraga *
            $nilai_akhir->wirama *
            $nilai_akhir->wirasa;
        $nilai_akhir->save();
    }
}