<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $jumlah_peserta = DB::table('m_jumlah_peserta')->value('jumlah');
        $query = DB::table('t_nilai_akhir')
            ->select('m_peserta.nama_lengkap', 't_nilai_akhir.nilai_akhir')
            ->join('m_peserta', 'm_peserta.id', '=', 't_nilai_akhir.peserta_id');

        // Menggunakan pluck sekali untuk mengurangi query ke database
        $dataAlternatif = $query->get()->pluck('nilai_akhir', 'nama_lengkap');
        $dataAlternatifNama = $dataAlternatif->keys();
        $dataAlternatifData = $dataAlternatif->values();

        // Menggunakan pluck sekali untuk mengurangi query ke database
        $sepuluhTerbesar = $query->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')->take($jumlah_peserta)->get()->pluck('nilai_akhir', 'nama_lengkap');
        $sepuluhTerbesarNama = $sepuluhTerbesar->keys();
        $sepuluhTerbesarData = $sepuluhTerbesar->values();

        return view('calculation', compact('dataAlternatifNama', 'dataAlternatifData', 'sepuluhTerbesarNama', 'sepuluhTerbesarData'));
    }
}