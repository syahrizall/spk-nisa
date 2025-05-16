<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function tambahEvent()
    {
        $kategoriPeserta = DB::table('m_kategori_peserta')->get();

        $data = DB::table('m_event')
            ->leftJoin('m_kategori_peserta', 'm_event.kategori_peserta_id', '=', 'm_kategori_peserta.id')
            ->select(
                'm_event.*',
                'm_kategori_peserta.nama as kategori_peserta_nama'
            )
            ->get();

        return view('dashboard.event.index', compact('data', 'kategoriPeserta'));

    }
    public function lihatEvent()
    {
        // Ambil event beserta peserta dan nama kategori peserta
        $events = DB::table('m_event as e')
            ->join('t_peserta_lomba_per_event as ple', 'e.id', '=', 'ple.event_id')
            ->join('m_peserta as p', 'ple.peserta_id', '=', 'p.id')
            ->leftJoin('m_kategori_peserta as k', 'e.kategori_peserta_id', '=', 'k.id')
            ->select(
                'e.id as event_id',
                'e.nama as event_nama',
                'e.kuota',
                'e.tanggal',
                'e.kategori_peserta_id',
                'k.nama as kategori_nama',
                'p.id as peserta_id',
                'p.nama_lengkap as peserta_nama'
            )
            ->get()
            ->groupBy('event_id');

        // Hitung berapa kali peserta ikut event per bulan
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

        // Ambil seluruh peserta dengan kategori
        $allPeserta = DB::table('m_peserta as p')
            ->leftJoin('m_kategori_peserta as k', 'p.kategori_peserta_id', '=', 'k.id')
            ->select('p.id', 'p.nama_lengkap', 'k.nama as kategori_nama')
            ->get();

        return view('dashboard.event.lihat-event', compact('events', 'pesertaEventCountByMonth', 'allPeserta'));
    }



    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Insert event beserta kategori_peserta_id
            $event = Event::create([
                'nama' => $request->nama,
                'kuota' => $request->kuota,
                'tanggal' => $request->tanggal,
                'kategori_peserta_id' => $request->kategori_peserta_id, // tambahkan kolom ini di form jika belum
            ]);

            // 2. Ambil peserta_id berdasarkan nilai_akhir tertinggi dan kategori yang dipilih
            $pesertaIds = DB::table('t_nilai_akhir')
                ->join('m_peserta', 't_nilai_akhir.peserta_id', '=', 'm_peserta.id')
                ->where('m_peserta.kategori_peserta_id', $request->kategori_peserta_id)
                ->orderByDesc('t_nilai_akhir.nilai_akhir')
                ->limit($request->kuota)
                ->pluck('t_nilai_akhir.peserta_id');

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
                'kategori_peserta_id' => $request->kategori_peserta_id, // Pastikan field ini ada di form
            ]);

            // 2. Hapus peserta lama dari event ini
            DB::table('t_peserta_lomba_per_event')
                ->where('event_id', $event->id)
                ->delete();

            // 3. Ambil ulang peserta_id berdasarkan kategori dan nilai tertinggi
            $pesertaIds = DB::table('t_nilai_akhir')
                ->join('m_peserta', 't_nilai_akhir.peserta_id', '=', 'm_peserta.id')
                ->where('m_peserta.kategori_peserta_id', $request->kategori_peserta_id)
                ->orderByDesc('t_nilai_akhir.nilai_akhir')
                ->limit($request->kuota)
                ->pluck('t_nilai_akhir.peserta_id');

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
