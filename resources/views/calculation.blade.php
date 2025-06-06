<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calculation - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('guest/assets/images/logo.png')}}" />
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('guest/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('guest/global.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />

    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Custom Styles -->
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            margin-top: 30px;
        }

        .reveal h1 {
            margin-top: 80px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <img src="{{asset('guest/assets/images/logo.png')}}" alt="Logo">
            <h1>SPK Penilaian Siswa Berprestasi</h1>
        </div>
        <button class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-menu">
            <a href="/"><i class="fas fa-home"></i> Home</a>
            <a href="{{ url('/kriteria') }}"><i class="fas fa-list-alt"></i> Kriteria</a>
            <a href="{{ url('/calculation') }}"><i class="fas fa-calculator"></i> Calculation</a>
            @if(auth()->user())
                <a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            @else
                <a href="{{ url('/login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mb-5">
        <!-- Header -->
        <div class="row reveal">
            <h1 class="text-center">DATA PERHITUNGAN CALON PESERTA TARI</h1>
            <hr/>
        </div>

        <!-- Chart Peserta per Kategori -->
        <div class="row reveal2">
            <h2 class="text-center mb-4">Nilai Peserta per Kategori</h2>
            @foreach($kategoriCharts as $kategoriId => $kategori)
                <div class="col-md-6 mb-4">
                    <figure class="highcharts-figure">
                        <div id="chartKategori{{ $kategoriId }}" style="height: 400px; margin:auto;"></div>
                    </figure>
                </div>
            @endforeach
        </div>

        <!-- Chart per Event -->
        <div class="row reveal2">
            <h2 class="text-center mb-4">Jumlah Peserta pada Setiap Event</h2>
            @foreach($eventCharts as $eventId => $event)
                <div class="col-md-6 mb-4">
                    <figure class="highcharts-figure">
                        <div id="chartEvent{{ $eventId }}" style="height: 400px; margin:auto;"></div>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navbarMenu = document.querySelector('.navbar-menu');

        mobileMenuBtn.addEventListener('click', () => {
            navbarMenu.classList.toggle('active');
        });

        // Reveal Animation Functions
        function reveal() {
            const reveals = document.querySelectorAll(".reveal");
            for (let i = 0; i < reveals.length; i++) {
                const windowHeight = window.innerHeight;
                const elementTop = reveals[i].getBoundingClientRect().top;
                const elementVisible = 0;

                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                } else {
                    reveals[i].classList.remove("active");
                }
            }
        }

        function reveal2() {
            const reveals = document.querySelectorAll(".reveal2");
            for (let i = 0; i < reveals.length; i++) {
                const windowHeight = window.innerHeight;
                const elementTop = reveals[i].getBoundingClientRect().top;
                const elementVisible = 0;

                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }

        // Chart Configurations
        @foreach($kategoriCharts as $kategoriId => $kategori)
            Highcharts.chart('chartKategori{{ $kategoriId }}', {
                chart: {
                    type: 'column',
                    backgroundColor: '#FCFFC5',
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
                    color: '#3b3b3b',
                    data: @json($kategori['nilai_akhir'])
                }]
            });
        @endforeach

        @foreach($eventCharts as $eventId => $event)
            Highcharts.chart('chartEvent{{ $eventId }}', {
                chart: {
                    type: 'column',
                    backgroundColor: '#FCFFC5',
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
                    color: '#3b3b3b',
                    data: @json($event['nilai_akhir'])
                }]
            });
        @endforeach

        // Event Listeners
        window.addEventListener("load", function() {
            reveal();
            const firstChart = document.querySelector('.reveal2');
            if (firstChart) {
                firstChart.classList.add("active");
            }
        });
        window.addEventListener("scroll", reveal2);
    </script>
</body>

</html>