@extends('dashboard.master')
@section('title', 'Event - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endsection
@section('content')

<style>
.marginCard {
    margin-bottom: 10px;
}

@media only screen and (min-width: 400px) and (max-width: 767px) {
    .marginResponsive {
        margin-top: 25px;
    }
}
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Data Event Detail') }}</h4>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif

                    @foreach ($events as $eventId => $eventGroup)
                        <div class="card marginCard">
                            <div class="card-body">
                                <h4 class="card-title">Peserta Event: {{ $eventGroup->first()->event_nama }}</h4>
                                <p>Kuota: {{ $eventGroup->first()->kuota }} | Tanggal: {{ \Carbon\Carbon::parse($eventGroup->first()->tanggal)->format('d-m-Y') }}</p>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
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
                                                    <span class="badge badge-warning">Mengikuti beberapa event di bulan yang sama</span>
                                                @else
                                                    <span class="badge badge-success">1 event saja</span>
                                                @endif
                                                </td>
                                                <td> 
                                                    <button type="button" class="btn btn-dark btn-sm btn-rounded btn-icon-prepend"
                                                data-toggle="modal" data-target="#edit{{$peserta->peserta_id}}">
                                                <i class="btn-icon-prepend"></i>Edit</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                            <!-- Modal Edit Peserta -->
                            @foreach ($eventGroup as $peserta)
                            <div class="modal fade" id="edit{{ $peserta->peserta_id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $peserta->peserta_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('updatePesertaEvent') }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="event_id" value="{{ $peserta->event_id }}">
                                        <input type="hidden" name="old_peserta_id" value="{{ $peserta->peserta_id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditLabel{{ $peserta->peserta_id }}">Edit Peserta Event</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Peserta Baru</label>
                                                <select name="new_peserta_id" class="form-control" required>
                                                    <option value="">-- Pilih Peserta --</option>
                                                    @foreach ($allPeserta as $p)
                                                        <option value="{{ $p->id }}" {{ $p->id == $peserta->peserta_id ? 'selected' : '' }}>
                                                            {{ $p->nama_lengkap }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
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
</div>




@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js">

</script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

});
</script>
@endsection