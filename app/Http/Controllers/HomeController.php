<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Data untuk chart per kategori
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
                'kategori_id' => $kategoriId,
                'kategori_nama' => $participants->first()->kategori_nama,
                'nama_peserta' => $participants->pluck('nama_lengkap'),
                'nilai_akhir' => $participants->pluck('nilai_akhir'),
                'max_value' => $participants->max('nilai_akhir') // Tambahkan max value dinamis
            ];
        }

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
                'event_id' => $eventId,
                'event_nama' => $participants->first()->event_nama,
                'nama_peserta' => $participants->pluck('nama_lengkap'),
                'nilai_akhir' => $participants->pluck('nilai_akhir'),
                'max_value' => $participants->max('nilai_akhir') // Tambahkan max value dinamis
            ];
        }

        // Hitung max value global untuk semua chart
        $globalMaxValue = DB::table('t_nilai_akhir')->max('nilai_akhir');
        
        // Jika tidak ada data, set default
        if (!$globalMaxValue) {
            $globalMaxValue = 1;
        }

        return view('calculation', compact(
            'kategoriCharts',
            'eventCharts',
            'globalMaxValue' // Tambahkan global max value
        ));
    }
}