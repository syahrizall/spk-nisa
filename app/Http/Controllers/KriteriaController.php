<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\KondisiRumah;
use Illuminate\Http\Request;
use App\Models\StatusPekerjaan;
use App\Models\KondisiKesehatan;
use App\Models\TingkatPendapatan;
use Illuminate\Support\Facades\DB;
use App\Models\JumlahAnggotaKeluarga;

class KriteriaController extends Controller
{
    public function indexBobot()
    {
        $data = Kriteria::all();
        return view('dashboard.bobot.index', compact('data'));
    }
    public function updateBobot(Request $request, $id)
    {
        $bobot = Kriteria::findOrFail($id);
        $bobot->bobot = $request->bobot;
        $bobot->save();
        return redirect('/bobot')->with('message', 'Data Berhasil Diubah');
    }
    public function indexNilai()
    {
        $kriteria = Kriteria::all();
        
        $tingkat_pendapatan = TingkatPendapatan::select('*', DB::raw("'C1' as kode"))->get();
        $jumlah_anggota_keluarga = JumlahAnggotaKeluarga::select('*', DB::raw("'C2' as kode"))->get();
        $status_pekerjaan = StatusPekerjaan::select('*', DB::raw("'C3' as kode"))->get();
        $kondisi_rumah = KondisiRumah::select('*', DB::raw("'C4' as kode"))->get();
        $kondisi_kesehatan = KondisiKesehatan::select('*', DB::raw("'C5' as kode"))->get();

        return view('dashboard.nilai.index', compact('kriteria', 'tingkat_pendapatan', 'jumlah_anggota_keluarga','status_pekerjaan', 'kondisi_rumah', 'kondisi_kesehatan'));
    }
    public function indexTingkatPendapatan()
    {
        $data = TingkatPendapatan::all();
        return view('dashboard.tingkat_pendapatan.index', compact('data'));
    }
    public function indexJumlahAnggotaKeluarga()
    {
        $data = JumlahAnggotaKeluarga::all();
        return view('dashboard.jumlah_anggota_keluarga.index', compact('data'));
    }
    public function indexStatusPekerjaan()
    {
        $data = StatusPekerjaan::all();
        return view('dashboard.status_pekerjaan.index', compact('data'));
    }
    public function indexKondisiRumah()
    {
        $data = KondisiRumah::all();
        return view('dashboard.kondisi_rumah.index', compact('data'));
    }
    public function indexKondisiKesehatan()
    {
        $data = KondisiKesehatan::all();
        return view('dashboard.kondisi_kesehatan.index', compact('data'));
    }
}
