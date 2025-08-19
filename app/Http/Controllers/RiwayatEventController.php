<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class RiwayatEventController extends Controller
{
    /**
     * Tampilkan halaman riwayat event
     */
    public function index()
    {
        // Ambil semua event yang sudah selesai
        $eventsSelesai = Event::selesai()
            ->with(['kategoriPeserta', 'pesertaLomba.peserta'])
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('dashboard.riwayat-event.index', compact('eventsSelesai'));
    }
}
