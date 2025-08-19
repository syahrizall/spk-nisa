@extends('dashboard.master')
@section('title', 'Data Penilaian - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
<style>
.card-bobot {
    border: none;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    background: #ffffff;
    color: #333;
}

.card-bobot:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.card-bobot-title {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 22px;
    font-weight: bold;
    color: #333;
    text-align: center;
}

.card-bobot-content {
    overflow-x: auto;
}

.card-bobot-content table {
    width: 100%;
    border-collapse: collapse;
}

.card-bobot-content th, .card-bobot-content td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.card-bobot-content th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.card-bobot-content tr:nth-child(even) {
    background-color: #f9f9f9;
}

.badge {
    font-size: 10px;
    padding: 4px 8px;
    border-radius: 12px;
    margin-left: 8px;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.card-keterangan {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            @if(session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Data Nilai Kriteria') }}</h4>
                    <div class="row">
                        @foreach($kriteria as $k)
                            <div class="col-md-6 mb-4">
                                <div class="card-bobot">
                                    <h5 class="card-bobot-title">{{$k->kode}} | {{$k->nama}} 
                                        @if($k->vektor == 'v')
                                            <span class="badge badge-success">Benefit</span>
                                        @else
                                            <span class="badge badge-warning">Cost</span>
                                        @endif
                                    </h5>
                                    <div class="card-bobot-content">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Range</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($k->kode == 'C1')
                                                    @foreach($wiraga as $item)
                                                        <tr>
                                                            <td>{{$item->range}}</td>
                                                            <td>{{$item->nilai}}</td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($k->kode == 'C2')
                                                    @foreach($wirama as $item)
                                                        <tr>
                                                            <td>{{$item->range}}</td>
                                                            <td>{{$item->nilai}}</td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($k->kode == 'C3')
                                                    @foreach($wirasa as $item)
                                                        <tr>
                                                            <td>{{$item->range}}</td>
                                                            <td>{{$item->nilai}}</td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($k->kode == 'C4')
                                                    @foreach($pengalaman as $item)
                                                        <tr>
                                                            <td>{{$item->range}}</td>
                                                            <td>{{$item->nilai}}</td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($k->kode == 'C5')
                                                    @foreach($ketidakhadiran as $item)
                                                        <tr>
                                                            <td>{{$item->range}}</td>
                                                            <td>{{$item->nilai}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($k->keterangan)
                                        <div class="card-keterangan">
                                            <small class="text-muted">
                                                <i class="ti-info-alt"></i> {{$k->keterangan}}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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
@endsection