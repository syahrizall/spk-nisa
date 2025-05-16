@extends('dashboard.master')
@section('title', 'Dashboard - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

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
        <!-- Card Total Peserta dan Peserta per Kategori -->
        <div class="col-12 col-md-6 grid-margin marginResponsive">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center pegawai">
                        <div class="container my-2">
                            <!-- Total Peserta -->
                            <div class="row justify-content-center mb-2">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm text-center bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title text-bold">Total Seluruh Peserta</h5>
                                            <h2 class="fw-bold">{{ $jumlah_peserta }} Peserta</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Peserta per Kategori -->
                            <div class="row">
                                @foreach ($pesertaPerKategori as $kategori)
                                    <div class="col-md-4 mb-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                                <span class="badge bg-danger mb-2">{{ $kategori->kategori_nama }}</span>
                                                <h5 class="fw-bold">{{ $kategori->total }} Peserta</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Peringkat Teratas -->
        <div class="col-12 col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center ranking mt-4">
                        <div class="text-center my-1">
                            <h2 class="fw-bold">🏆 Peringkat Teratas Setiap Kategori</h2>
                            <p class="text-muted">Berikut adalah peserta dengan nilai tertinggi dari masing-masing kategori</p>
                        </div>
                        
                        @if ($rankingAll && $rankingAll->count())
                            <div class="container">
                                <div class="row justify-content-center">
                                    @foreach ($rankingAll as $ranking)
                                        <div class="col-md-4 d-flex align-items-stretch mb-2">
                                            <div class="card shadow-sm w-100 border-0" style="background-color: #f8f9fa;">
                                                <div class="card-body d-flex flex-column align-items-center text-center" style="min-height: 100px;">
                                                    <span class="badge bg-danger mb-2">{{ $ranking->kategori_peserta }}</span>
                                                    <h5 class="card-title fw-semibold mb-2">{{ $ranking->nama_lengkap }}</h5>
                                                    <p class="card-text mb-0"><strong>{{ $ranking->nilai_akhir }}</strong></p>
                                                </div>                                                
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <h4 class="text-center mt-4">Tidak Ada Data</h4>
                        @endif                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Peserta per Kategori -->
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5 class="card-title text-center fw-bold mb-3">📊 Nilai Peserta per Kategori</h5>
                        @foreach($kategoriCharts as $kategoriId => $kategori)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <figure class="highcharts-figure">
                                        <div id="chartKategori{{ $kategoriId }}" style="height: 400px; margin:auto;"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart per Event -->
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5 class="card-title text-center fw-bold mb-3">📊 Jumlah Peserta pada Setiap Event</h5>
                        @foreach($eventCharts as $eventId => $event)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <figure class="highcharts-figure">
                                        <div id="chartEvent{{ $eventId }}" style="height: 400px; margin:auto;"></div>
                                    </figure>
                                </div>
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

<!-- Highcharts Scripts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

@section('script')
<script type="text/javascript">
    // Chart untuk setiap kategori
    @foreach($kategoriCharts as $kategoriId => $kategori)
    Highcharts.chart('chartKategori{{ $kategoriId }}', {
        chart: {
            type: 'column',
            borderRadius: 10
        },
        title: {
            text: '{{ $kategori["kategori_nama"] }}',
            align: 'center'
        },
        xAxis: {
            categories: @json($kategori['nama_peserta']),
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
            data: @json($kategori['nilai_akhir'])
        }]
    });
    @endforeach

    // Chart untuk setiap event
    @foreach($eventCharts as $eventId => $event)
    Highcharts.chart('chartEvent{{ $eventId }}', {
        chart: {
            type: 'column',
            borderRadius: 10
        },
        title: {
            text: '{{ $event["event_nama"] }}',
            align: 'center'
        },
        xAxis: {
            categories: @json($event['nama_peserta']),
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
            data: @json($event['nilai_akhir'])
        }]
    });
    @endforeach
</script>
@endsection