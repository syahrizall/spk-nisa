<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total peserta (unik berdasarkan peserta_id di t_nilai_akhir)
        $jumlah_peserta = DB::table('t_nilai_akhir')
        ->distinct('peserta_id')
        ->count('peserta_id');

        // Jumlah peserta per kategori
        $pesertaPerKategori = DB::table('t_nilai_akhir')
        ->join('m_peserta', 'm_peserta.id', '=', 't_nilai_akhir.peserta_id')
        ->join('m_kategori_peserta', 'm_peserta.kategori_peserta_id', '=', 'm_kategori_peserta.id')
        ->select('m_kategori_peserta.id as kategori_id', 'm_kategori_peserta.nama as kategori_nama', DB::raw('COUNT(DISTINCT t_nilai_akhir.peserta_id) as total'))
        ->groupBy('m_kategori_peserta.id', 'm_kategori_peserta.nama')
        ->get();

        $rankingAll = DB::table('t_nilai_akhir')
            ->select('m_peserta.nama_lengkap', 't_nilai_akhir.nilai_akhir', 'm_peserta.kategori_peserta_id', 'm_kategori_peserta.nama as kategori_peserta')
            ->join('m_peserta', 'm_peserta.id', '=', 't_nilai_akhir.peserta_id')
            ->join('m_kategori_peserta', 'm_peserta.kategori_peserta_id', '=', 'm_kategori_peserta.id')
            ->orderBy('m_peserta.kategori_peserta_id') // penting untuk urutan group
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->get()
            ->groupBy('kategori_peserta_id')
            ->map(function ($group) {
                return $group->first(); // ambil top 1 dari setiap kategori
            })
            ->values(); // reset key agar indeks rapi (optional)

        // Data untuk chart per event
        $eventData = DB::table('m_event')
            ->select(
                'm_event.id as event_id',
                'm_event.nama as event_nama',
                'm_peserta.nama_lengkap',
                't_nilai_akhir.nilai_akhir'
            )
            ->join('t_peserta_lomba_per_event', 'm_event.id', '=', 't_peserta_lomba_per_event.event_id')
            ->join('m_peserta', 't_peserta_lomba_per_event.peserta_id', '=', 'm_peserta.id')
            ->join('t_nilai_akhir', 'm_peserta.id', '=', 't_nilai_akhir.peserta_id')
            ->orderBy('m_event.id')
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->get()
            ->groupBy('event_id');

        $eventCharts = [];
        foreach ($eventData as $eventId => $participants) {
            $eventCharts[$eventId] = [
                'event_nama' => $participants->first()->event_nama,
                'nama_peserta' => $participants->pluck('nama_lengkap'),
                'nilai_akhir' => $participants->pluck('nilai_akhir')
            ];
        }

        // Data untuk chart peserta per kategori
        $pesertaPerKategoriChart = DB::table('t_nilai_akhir')
            ->select(
                'm_kategori_peserta.id as kategori_id',
                'm_kategori_peserta.nama as kategori_nama',
                'm_peserta.nama_lengkap',
                't_nilai_akhir.nilai_akhir'
            )
            ->join('m_peserta', 'm_peserta.id', '=', 't_nilai_akhir.peserta_id')
            ->join('m_kategori_peserta', 'm_peserta.kategori_peserta_id', '=', 'm_kategori_peserta.id')
            ->orderBy('m_kategori_peserta.id')
            ->orderBy('t_nilai_akhir.nilai_akhir', 'DESC')
            ->get()
            ->groupBy('kategori_id');

        $kategoriCharts = [];
        foreach ($pesertaPerKategoriChart as $kategoriId => $participants) {
            $kategoriCharts[$kategoriId] = [
                'kategori_nama' => $participants->first()->kategori_nama,
                'nama_peserta' => $participants->pluck('nama_lengkap'),
                'nilai_akhir' => $participants->pluck('nilai_akhir')
            ];
        }

        return view('dashboard.dashboard', compact([
            'jumlah_peserta', 
            'rankingAll', 
            'pesertaPerKategori',
            'eventCharts',
            'kategoriCharts'
        ]));
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