@extends('dashboard.master')
@section('title', 'Riwayat Event - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
<style>
    .marginCard {
        margin-bottom: 10px;
    }

    @media only screen and (min-width: 400px) and (max-width: 767px) {
        .marginResponsive {
            margin-top: 25px;
        }
    }
    
    .participant-list {
        max-width: 200px;
    }
    
    .participant-item {
        margin-bottom: 3px;
    }
    
    .participant-item .badge {
        font-size: 11px;
        padding: 4px 8px;
        margin-right: 2px;
        display: inline-block;
        margin-bottom: 2px;
    }
    
    /* Button styling */
    .btn-outline-info {
        border-color: #17a2b8;
        color: #17a2b8;
        font-size: 11px;
        padding: 4px 8px;
    }
    
    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Riwayat Event') }}</h4>
                    
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Event</th>
                                    <th>Kuota</th>
                                    <th>Kategori Peserta</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Daftar Peserta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($eventsSelesai as $event)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <strong>{{ $event->nama }}</strong>
                                        @if($event->deskripsi)
                                            <br><small class="text-muted">{{ Str::limit($event->deskripsi, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $event->kuota }}</td>
                                    <td>{{ optional($event->kategoriPeserta)->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $event->lokasi ?? '-' }}</td>
                                    <td>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    data-toggle="modal" data-target="#modalPeserta{{ $event->id }}">
                                                <i class="ti-eye"></i> Lihat Semua Peserta
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Daftar Peserta -->
@foreach($eventsSelesai as $event)
<div class="modal fade" id="modalPeserta{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="modalPesertaLabel{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPesertaLabel{{ $event->id }}">
                    <i class="ti-users"></i> Daftar Peserta - {{ $event->nama }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->tanggal)->format('d-m-Y') }}</p>
                        <p><strong>Lokasi:</strong> {{ $event->lokasi ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Kategori:</strong> {{ optional($event->kategoriPeserta)->nama ?? '-' }}</p>
                        <p><strong>Total Peserta:</strong> {{ $event->pesertaLomba->count() }}</p>
                    </div>
                </div>
                
                @if($event->pesertaLomba->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peserta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($event->pesertaLomba as $pesertaLomba)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            <strong>{{ $pesertaLomba->peserta->nama_lengkap }}</strong>
                                            @if($pesertaLomba->peserta->asal_sekolah)
                                                <br><small class="text-muted">{{ $pesertaLomba->peserta->asal_sekolah }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti-user" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-2">Tidak ada peserta terdaftar</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
@endsection
