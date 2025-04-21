@extends('dashboard.master')
@section('title', 'Dashboard - Sistem Pendukung Keputusan Kelayakan Penerimaan Bantuan Raskin Di Kelurahan Maleber')
@section('custom-css')
<style>
.pegawai img, .ranking img {
    margin: auto;
}

.pegawai img {
    width: 100%;
    height: 300px;
    animation: pegawai 1s;
}

.ranking img {
    width: 100%;
    height: 260px;
    animation: ranking 3s;
}

@keyframes pegawai {
    0% { top: 200px; }
    100% { top: 0px; }
}

@keyframes ranking {
    0% { transform: rotateY(0deg); }
    100% { transform: rotateY(-360deg); }
}

@media only screen and (min-width: 400px) and (max-width: 767px) {
    .marginResponsive {
        margin-top: 25px;
    }
}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 col-md-6 grid-margin marginResponsive">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center pegawai">
                        <img src="{{asset('guest/assets/images/pegawai.png')}}">
                        <h4>Jumlah Penerima Bantuan : {{$jumlah_penerima}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center ranking mt-4">
                        <img src="{{asset('guest/assets/images/ranking.png')}}">
                        @if ($ranking1)
                            <h4 class="mt-3">{{$ranking1->nama}}</h4>
                        @else
                            <h4 class="mt-3">Tidak Ada Data</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <!-- Tambahkan alert success -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row">
                        <form action="{{ route('updateJumlahPenerima') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <h4>Update Jumlah Penerima:</h4>
                                    <input type="number" class="form-control" id="jumlah_penerima" name="jumlah_penerima" value="{{$jumlah_penerima}}">
                                </div>
                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <figure class="highcharts-figure">
                            <div id="chart1" style="height: 500px; margin:auto;"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- hightchart -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@section('script')
<script type="text/javascript">
var chartCategories = @json($sepuluhTerbesarNama);
var chartData = @json($sepuluhTerbesarData);
Highcharts.chart('chart1', {
    chart: {
        type: 'column',
        borderRadius: 10
    },
    title: {
        text: 'Penerima Bantuan',
        align: 'center'
    },
    xAxis: {
        categories: chartCategories,
        crosshair: true
    },
    yAxis: {
        min: 0,
        max: 5,
        title: {
            text: 'Nilai Akhir'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:12px;">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color}; padding:0; text-align:center;"></td>' +
            '<td style="padding:0; font-size:12px;"><b>Nilai Akhir&nbsp;{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Nilai Akhir',
        color: '#F3CB51',
        data: chartData
    }]
});
</script>
@endsection