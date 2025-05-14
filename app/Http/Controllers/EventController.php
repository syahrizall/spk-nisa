<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function tambahEvent()
    {
        $data = Event::all();
        return view('dashboard.event.index', compact('data'));
    }

    public function lihatEvent()
    {
        $events = DB::table('m_event as e')
        ->join('t_peserta_lomba_per_event as ple', 'e.id', '=', 'ple.event_id')
        ->join('m_peserta as p', 'ple.peserta_id', '=', 'p.id')
        ->select(
            'e.id as event_id',
            'e.nama as event_nama',
            'e.kuota',
            'e.tanggal',
            'p.id as peserta_id',
            'p.nama_lengkap as peserta_nama'
        )
        ->get()
        ->groupBy('event_id');

        // Hitung berapa event yang diikuti peserta tiap bulan
        $pesertaEventCountByMonth = DB::table('t_peserta_lomba_per_event as ple')
        ->join('m_event as e', 'ple.event_id', '=', 'e.id')
        ->select(
            'ple.peserta_id',
            DB::raw("DATE_FORMAT(e.tanggal, '%Y-%m') as bulan"),
            DB::raw("count(*) as total_event")
        )
        ->groupBy('ple.peserta_id', 'bulan')
        ->having('total_event', '>', 1)
        ->get()
        ->groupBy('peserta_id');

        $allPeserta = DB::table('m_peserta')->get();

        return view('dashboard.event.lihat-event', compact('events', 'pesertaEventCountByMonth', 'allPeserta'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Insert event
            $event = Event::create([
                'nama' => $request->nama,
                'kuota' => $request->kuota,
                'tanggal' => $request->tanggal,
            ]);

            // 2. Ambil peserta_id berdasarkan nilai_akhir tertinggi sesuai kuota
            $pesertaIds = DB::table('t_nilai_akhir')
                ->orderByDesc('nilai_akhir')
                ->limit($request->kuota)
                ->pluck('peserta_id');

            // 3. Insert ke t_peserta_lomba_per_event
            $data = $pesertaIds->map(function ($pesertaId) use ($event) {
                return [
                    'event_id' => $event->id,
                    'peserta_id' => $pesertaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            DB::table('t_peserta_lomba_per_event')->insert($data);
        });

        return redirect('/tambah-event')->with('message', 'Data Berhasil Disimpan');
    }
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            // 1. Update event
            $event = Event::findOrFail($id);
            $event->update([
                'nama' => $request->nama,
                'kuota' => $request->kuota,
                'tanggal' => $request->tanggal,
            ]);
    
            // 2. Hapus peserta lama dari event ini
            DB::table('t_peserta_lomba_per_event')
                ->where('event_id', $event->id)
                ->delete();
    
            // 3. Ambil ulang peserta_id tertinggi sesuai kuota baru
            $pesertaIds = DB::table('t_nilai_akhir')
                ->orderByDesc('nilai_akhir')
                ->limit($request->kuota)
                ->pluck('peserta_id');
    
            // 4. Insert ulang peserta ke event
            $data = $pesertaIds->map(function ($pesertaId) use ($event) {
                return [
                    'event_id' => $event->id,
                    'peserta_id' => $pesertaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();
    
            DB::table('t_peserta_lomba_per_event')->insert($data);
        });

        return redirect('/tambah-event')->with('message', 'Data Berhasil Diperbarui');
    }

    public function updatePesertaEvent(Request $request)
    {
        DB::table('t_peserta_lomba_per_event')
            ->where('event_id', $request->event_id)
            ->where('peserta_id', $request->old_peserta_id)
            ->update([
                'peserta_id' => $request->new_peserta_id
            ]);

        return redirect()->back()->with('message', 'Peserta berhasil diubah.');
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            // 1. Hapus data peserta lomba terkait event
            DB::table('t_peserta_lomba_per_event')
                ->where('event_id', $id)
                ->delete();
    
            // 2. Hapus event-nya
            Event::where('id', $id)->delete();
        });

        return redirect('/tambah-event')->with('message', 'Data Berhasil Dihapus');
    }
}
