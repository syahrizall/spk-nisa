<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wiraga;
use App\Models\Wirama;
use App\Models\Wirasa;
use App\Models\Pengalaman;
use App\Models\Ketidakhadiran;

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
        
        $wiraga = Wiraga::select('*', DB::raw("'C1' as kode"))->get();
        $wirama = Wirama::select('*', DB::raw("'C2' as kode"))->get();
        $wirasa = Wirasa::select('*', DB::raw("'C3' as kode"))->get();
        $pengalaman = Pengalaman::select('*', DB::raw("'C4' as kode"))->get();
        $ketidakhadiran = Ketidakhadiran::select('*', DB::raw("'C5' as kode"))->get();

        return view('dashboard.nilai.index', compact('kriteria', 'wiraga', 'wirama', 'wirasa', 'pengalaman', 'ketidakhadiran'));
    }
    public function indexWiraga()
    {
        $data = Wiraga::all();
        return view('dashboard.wiraga.index', compact('data'));
    }
}
