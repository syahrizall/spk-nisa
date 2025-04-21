<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_penerima = DB::table('m_jumlah_penerima')->value('jumlah');

        $ranking1 = DB::table('t_nilai_akhir')
            ->select('m_penerima.nama', 't_nilai_akhir.nilai_akhir')
            ->join('m_penerima', 'm_penerima.id', '=', 't_nilai_akhir.penerima_id')
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->first();

        $sepuluhTerbesar = DB::table('t_nilai_akhir')
            ->select('m_penerima.nama', 't_nilai_akhir.nilai_akhir')
            ->join('m_penerima', 'm_penerima.id', '=', 't_nilai_akhir.penerima_id')
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->take($jumlah_penerima)
            ->get();

        $sepuluhTerbesarNama = $sepuluhTerbesar->pluck('nama');
        $sepuluhTerbesarData = $sepuluhTerbesar->pluck('nilai_akhir');

        return view('dashboard.dashboard', compact(['jumlah_penerima', 'ranking1', 'sepuluhTerbesarNama', 'sepuluhTerbesarData']));
    }

    public function updateJumlahPenerima(Request $request)
    {
        $request->validate([
            'jumlah_penerima' => 'required|integer|min:0',
        ]);

        // Update data jumlah penerima di database
        DB::table('m_jumlah_penerima')->update(['jumlah' => $request->jumlah_penerima]);

        return redirect()->back()->with('success', 'Jumlah penerima berhasil diupdate.');
    }
}