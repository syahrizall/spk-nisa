<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $jumlah_penerima = DB::table('m_jumlah_penerima')->value('jumlah');
        $query = DB::table('t_nilai_akhir')
            ->select('m_penerima.nama', 't_nilai_akhir.nilai_akhir')
            ->join('m_penerima', 'm_penerima.id', '=', 't_nilai_akhir.penerima_id');

        // Menggunakan pluck sekali untuk mengurangi query ke database
        $dataAlternatif = $query->get()->pluck('nilai_akhir', 'nama');
        $dataAlternatifNama = $dataAlternatif->keys();
        $dataAlternatifData = $dataAlternatif->values();

        // Menggunakan pluck sekali untuk mengurangi query ke database
        $sepuluhTerbesar = $query->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')->take($jumlah_penerima)->get()->pluck('nilai_akhir', 'nama');
        $sepuluhTerbesarNama = $sepuluhTerbesar->keys();
        $sepuluhTerbesarData = $sepuluhTerbesar->values();

        return view('calculation', compact('dataAlternatifNama', 'dataAlternatifData', 'sepuluhTerbesarNama', 'sepuluhTerbesarData'));
    }
}