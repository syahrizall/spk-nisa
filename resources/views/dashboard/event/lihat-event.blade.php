@extends('dashboard.master')
@section('title', 'Event - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
<!-- Google Font Modern -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f5f7fa;
    }

    .event-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .badge-success {
        background-color: #28a745;
        padding: 6px 12px;
        border-radius: 12px;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 500;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .badge-warning {
        background-color: #ffc107;
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #000;
    }

    .btn-outline-primary {
        border-radius: 20px;
        font-size: 0.85rem;
        padding: 5px 12px;
        transition: all 0.2s ease-in-out;
        border: 1px solid #667eea;
        background-color: white;
        color: #667eea;
    }

    .btn-outline-primary:hover {
        background-color: #667eea;
        color: white;
    }

    .card {
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .table th {
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            <div class="card p-4">
                <h3 class="mb-4">📋 Daftar Event & Peserta</h3>

                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif

                @foreach ($events as $eventId => $eventGroup)
                    <div class="event-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>📌 {{ $eventGroup->first()->event_nama }}</strong><br>
                                📊 Kuota: {{ $eventGroup->first()->kuota }} |
                                📅 Tanggal: {{ \Carbon\Carbon::parse($eventGroup->first()->tanggal)->format('d-m-Y') }} |
                                🏷️ Kategori: {{ $eventGroup->first()->kategori_nama }}
                            </div>
                            <div>
                                <a href="{{ route('markEventCompleted', ['id' => $eventId]) }}" 
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('Apakah anda yakin ingin menandai event ini sebagai selesai?')">
                                    ✅ Selesai
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-striped" id="dataTable{{ $eventId }}">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Peserta</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventGroup as $index => $peserta)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $peserta->peserta_nama }}</td>
                                        <td>
                                            @php
                                                $bulan = \Carbon\Carbon::parse($peserta->tanggal)->format('Y-m');
                                                $pesertaBulan = $pesertaEventCountByMonth[$peserta->peserta_id] ?? collect();
                                                $ikutBanyakEvent = $pesertaBulan->firstWhere('bulan', $bulan);
                                            @endphp

                                            @if ($ikutBanyakEvent)
                                                <span class="badge badge-warning">>1 event</span>
                                            @else
                                                <span class="badge badge-success">1 event</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit{{$peserta->peserta_id}}" data-kategori="{{ $peserta->kategori_nama }}">
                                                ✏️ Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Edit -->
                    @foreach ($eventGroup as $peserta)
                        <div class="modal fade" id="edit{{ $peserta->peserta_id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $peserta->peserta_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('updatePesertaEvent') }}" method="POST" class="modal-content">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="event_id" value="{{ $peserta->event_id }}">
                                    <input type="hidden" name="old_peserta_id" value="{{ $peserta->peserta_id }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Peserta Event</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama Peserta Baru</label>
                                            <select name="new_peserta_id" class="form-control" required>
                                                <option value="">-- Pilih Peserta --</option>
                                                @foreach ($allPeserta->where('kategori_nama', $peserta->kategori_nama) as $p)
                                                    <option value="{{ $p->id }}" {{ $p->id == $peserta->peserta_id ? 'selected' : '' }}>
                                                        {{ $p->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        @foreach ($events as $eventId => $group)
        $('#dataTable{{ $eventId }}').DataTable();
        @endforeach
    });
</script>
@endsection
