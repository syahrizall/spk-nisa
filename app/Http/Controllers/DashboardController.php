<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_peserta = DB::table('m_jumlah_peserta')->value('jumlah');

        $ranking1 = DB::table('t_nilai_akhir')
            ->select('m_peserta.nama_lengkap', 't_nilai_akhir.nilai_akhir')
            ->join('m_peserta', 'm_peserta.id', '=', 't_nilai_akhir.peserta_id')
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->first();

        $sepuluhTerbesar = DB::table('t_nilai_akhir')
            ->select('m_peserta.nama_lengkap', 't_nilai_akhir.nilai_akhir')
            ->join('m_peserta', 'm_peserta.id', '=', 't_nilai_akhir.peserta_id')
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->take($jumlah_peserta)
            ->get();

        $sepuluhTerbesarNama = $sepuluhTerbesar->pluck('nama_lengkap');
        $sepuluhTerbesarData = $sepuluhTerbesar->pluck('nilai_akhir');

        return view('dashboard.dashboard', compact(['jumlah_peserta', 'ranking1', 'sepuluhTerbesarNama', 'sepuluhTerbesarData']));
    }

    public function updateJumlahPeserta(Request $request)
    {
        $request->validate([
            'jumlah_peserta' => 'required|integer|min:0',
        ]);

        // Update data jumlah peserta di database
        DB::table('m_jumlah_peserta')->update(['jumlah' => $request->jumlah_peserta]);

        return redirect()->back()->with('success', 'Jumlah peserta berhasil diupdate.');
    }
}