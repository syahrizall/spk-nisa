<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JumlahAnggotaKeluarga;
use App\Models\KondisiKesehatan;
use App\Models\KondisiRumah;
use App\Models\Penerima;
use App\Models\StatusPekerjaan;
use App\Models\TingkatPendapatan;
use Illuminate\Support\Facades\DB;

class PenerimaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_penerima')
        ->select('m_penerima.*', 'm_tingkat_pendapatan.range as tingkat_pendapatan', 'm_jumlah_anggota_keluarga.range as jumlah_anggota_keluarga', 'm_status_pekerjaan.range as status_pekerjaan', 'm_kondisi_rumah.range as kondisi_rumah', 'm_kondisi_kesehatan.range as kondisi_kesehatan', 'm_tingkat_pendapatan.id as tingkat_pendapatan_id', 'm_jumlah_anggota_keluarga.id as jumlah_anggota_keluarga_id', 'm_status_pekerjaan.id as status_pekerjaan_id', 'm_kondisi_rumah.id as kondisi_rumah_id', 'm_kondisi_kesehatan.id as kondisi_kesehatan_id')
        ->join('m_tingkat_pendapatan', 'm_penerima.tingkat_pendapatan', '=', 'm_tingkat_pendapatan.id')
        ->join('m_jumlah_anggota_keluarga', 'm_penerima.jumlah_anggota_keluarga', '=', 'm_jumlah_anggota_keluarga.id')
        ->join('m_status_pekerjaan', 'm_penerima.status_pekerjaan', '=', 'm_status_pekerjaan.id')
        ->join('m_kondisi_rumah', 'm_penerima.kondisi_rumah', '=', 'm_kondisi_rumah.id')
        ->join('m_kondisi_kesehatan', 'm_penerima.kondisi_kesehatan', '=', 'm_kondisi_kesehatan.id')
        ->orderBy('m_penerima.nama', 'ASC')
        ->get();
        // dd($data);
        $tingkat_pendapatan = TingkatPendapatan::all();
        $jumlah_anggota_keluarga = JumlahAnggotaKeluarga::all();
        $status_pekerjaan = StatusPekerjaan::all();
        $kondisi_rumah = KondisiRumah::all();
        $kondisi_kesehatan = KondisiKesehatan::all();

        return view('dashboard.penerima.index', compact('data', 'tingkat_pendapatan', 'jumlah_anggota_keluarga', 'status_pekerjaan', 'kondisi_rumah', 'kondisi_kesehatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_kk' => 'required|string|',
            'nik' => 'required|string',
            'no_telpon' => 'required|string'
        ]);

        Penerima::create($request->all());

        return redirect('/penerima')->with('message', 'Data Berhasil Disimpan');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_kk' => 'required|string|',
            'nik' => 'required|string',
            'no_telpon' => 'required|string'
        ]);

        $penerima = Penerima::find($id);
        $penerima->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_kk' => $request->no_kk,
            'nik' => $request->nik,
            'no_telpon' => $request->no_telpon,
            'tingkat_pendapatan' => $request->tingkat_pendapatan,
            'jumlah_anggota_keluarga' => $request->jumlah_anggota_keluarga,
            'status_pekerjaan' => $request->status_pekerjaan,
            'kondisi_rumah' => $request->kondisi_rumah,
            'kondisi_kesehatan' => $request->kondisi_kesehatan,
        ]);
        return redirect('/penerima')->with('message', 'Data Berhasil Diubah');
    }
    public function delete($id)
    {
        $penerima = Penerima::find($id);
        $penerima->delete();

        // $data_alternatif = DataAlternatif::where('pegawai_id', $id)->first();
        // $data_alternatif->delete();

        // $data_nilai_akhir = NilaiAkhir::where('pegawai_id', $id)->first();
        // $data_nilai_akhir->delete();

        return redirect('/penerima')->with('message', 'Data Berhasil Dihapus');
    }
}