<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerima;
use App\Models\Peserta;
use App\Models\Wiraga;
use App\Models\Wirama;
use App\Models\Wirasa;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_peserta')
        ->select('m_peserta.*', 'm_wiraga.range as wiraga', 'm_wirama.range as wirama', 'm_wirasa.range as wirasa', 'm_wiraga.id as wiraga_id', 'm_wirama.id as wirama_id', 'm_wirasa.id as wirasa_id')
        ->join('m_wiraga', 'm_peserta.wiraga', '=', 'm_wiraga.id')
        ->join('m_wirama', 'm_peserta.wirama', '=', 'm_wirama.id')
        ->join('m_wirasa', 'm_peserta.wirasa', '=', 'm_wirasa.id')
        ->orderBy('m_peserta.nama_lengkap', 'ASC')
        ->get();
        // dd($data);
        $wiraga = Wiraga::all();
        $wirama = Wirama::all();
        $wirasa = Wirasa::all();

        return view('dashboard.peserta.index', compact('data', 'wiraga', 'wirama', 'wirasa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'required|date',
            'asal_sekolah'   => 'required|string|max:255',
            'nomor_hp'       => 'required|string|max:15',
            'wiraga'         => 'required|string',
            'wirama'         => 'required|string',
            'wirasa'         => 'required|string',
        ]);

        Peserta::create($request->all());

        return redirect('/peserta')->with('message', 'Data Berhasil Disimpan');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'required|date',
            'asal_sekolah'   => 'required|string|max:255',
            'nomor_hp'       => 'required|string|max:15',
            'wiraga'         => 'required|string',
            'wirama'         => 'required|string',
            'wirasa'         => 'required|string',
        ]);

        $peserta = Peserta::findOrFail($id);

        $peserta->update([
            'nama_lengkap'   => $request->nama_lengkap,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'asal_sekolah'   => $request->asal_sekolah,
            'nomor_hp'       => $request->nomor_hp,
            'wiraga'         => $request->wiraga,
            'wirama'         => $request->wirama,
            'wirasa'         => $request->wirasa,
        ]);

        return redirect('/peserta')->with('message', 'Data Berhasil Diperbarui');
    }

    public function delete($id)
    {
        $peserta = Peserta::find($id);
        $peserta->delete();

        // $data_alternatif = DataAlternatif::where('pegawai_id', $id)->first();
        // $data_alternatif->delete();

        // $data_nilai_akhir = NilaiAkhir::where('pegawai_id', $id)->first();
        // $data_nilai_akhir->delete();

        return redirect('/peserta')->with('message', 'Data Berhasil Dihapus');
    }
}