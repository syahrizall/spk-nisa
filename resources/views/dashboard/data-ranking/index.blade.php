@extends('dashboard.master')
@section('title', 'Data Ranking - Sistem Pendukung Keputusan Kelayakan Penerimaan Bantuan Raskin Di Kelurahan Maleber')

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
                    <h4 class="card-title">{{ __('Data Ranking') }}</h4>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                            <thead>
                                <tr>
                                    <a href="{{route('refreshRanking')}}" class="btn btn-secondary btn-rounded"
                                        onclick="return confirm('Apakah anda yakin ?')">Refresh Data
                                        <i class="ti-wand btn-icon-append"></i></a>
                                </tr>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tingkat Pendapatan</th>
                                    <th>Jumlah Anggota Keluarga</th>
                                    <th>Status Pekerjaan</th>
                                    <th>Kondisi Rumah</th>
                                    <th>Kondisi Kesehatan</th>
                                    <th>Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($data as $row)
                                    <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$row->nama_penerima}}</td>
                                    <td>{{$row->tingkat_pendapatan}}</td>
                                    <td>{{$row->jumlah_anggota_keluarga}}</td>
                                    <td>{{$row->status_pekerjaan}}</td>
                                    <td>{{$row->kondisi_rumah}}</td>
                                    <td>{{$row->kondisi_kesehatan}}</td>
                                    <td>{{$row->nilai_akhir}}</td>
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
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js">

</script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

});
</script>
@endsection