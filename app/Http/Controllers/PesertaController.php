<?php

namespace App\Http\Controllers;

use App\Models\KategoriPeserta;
use Illuminate\Http\Request;
use App\Models\Penerima;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_peserta')
        ->select('m_peserta.*', 'm_kategori_peserta.nama as kategori_peserta', 'm_kategori_peserta.id as kategori_peserta_id')
        ->join('m_kategori_peserta', 'm_peserta.kategori_peserta_id', '=', 'm_kategori_peserta.id')
        ->orderBy('m_peserta.nama_lengkap', 'ASC')
        ->get();
        
        $kategori_peserta = KategoriPeserta::all();

        return view('dashboard.peserta.index', compact('data', 'kategori_peserta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'          => 'required|string|max:255',
            'kategori_peserta_id'   => 'required',
            'jenis_kelamin'         => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'         => 'required|date',
            'asal_sekolah'          => 'required|string|max:255',
            'nomor_hp'              => 'required|string|max:15',
            'wiraga'                => 'required|numeric|min:0|max:100',
            'wirama'                => 'required|numeric|min:0|max:100',
            'wirasa'                => 'required|numeric|min:0|max:100',
            'pengalaman'            => 'required|numeric|min:0|max:10',
            'ketidakhadiran'        => 'required|numeric|min:0|max:30',
        ]);

        Peserta::create($request->all());

        return redirect('/peserta')->with('message', 'Data Berhasil Disimpan');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap'          => 'required|string|max:255',
            'kategori_peserta_id'   => 'required',
            'jenis_kelamin'         => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'         => 'required|date',
            'asal_sekolah'          => 'required|string|max:255',
            'nomor_hp'              => 'required|string|max:15',
            'wiraga'                => 'required|numeric|min:0|max:100',
            'wirama'                => 'required|numeric|min:0|max:100',
            'wirasa'                => 'required|numeric|min:0|max:100',
            'pengalaman'            => 'required|numeric|min:0|max:10',
            'ketidakhadiran'        => 'required|numeric|min:0|max:30',
        ]);

        $peserta = Peserta::findOrFail($id);

        $peserta->update([
            'nama_lengkap'          => $request->nama_lengkap,
            'kategori_peserta_id'   => $request->kategori_peserta_id,
            'jenis_kelamin'         => $request->jenis_kelamin,
            'tanggal_lahir'         => $request->tanggal_lahir,
            'asal_sekolah'          => $request->asal_sekolah,
            'nomor_hp'              => $request->nomor_hp,
            'wiraga'                => $request->wiraga,
            'wirama'                => $request->wirama,
            'wirasa'                => $request->wirasa,
            'pengalaman'            => $request->pengalaman,
            'ketidakhadiran'        => $request->ketidakhadiran,
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