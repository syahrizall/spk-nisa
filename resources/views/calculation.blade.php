<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calculation - Sistem Pendukung Keputusan Kelayakan Penerimaan Bantuan Raskin Di Kelurahan Maleber</title>
    <link rel="shortcut icon" href="{{asset('guest/assets/images/logo.png')}}" />
    <link rel="stylesheet" href="{{asset('guest/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('guest/global.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />

    <!-- hightchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

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
    <!--Navbar-->
    <nav class="navbar">
        <div class="navbar-brand">
            <img src="{{asset('guest/assets/images/logo.png')}}" alt="Logo">
            <h1>SPK Bantuan Raskin</h1>
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

    <!--Main Body Content-->
    <div class="container mb-5">
        <div class="row reveal">
            <h1 class="text-center">DATA PERHITUNGAN CALON PENERIMA BANTUAN RASKIN</h1>
            <hr/>
        </div>
        <div class="row reveal">
            <figure class="highcharts-figure">
                <div id="chart1" style="height: 500px; margin:auto;"></div>
            </figure>
        </div>
        <div class="row reveal2">
            <figure class="highcharts-figure">
                <div id="chart2" style="height: 500px; margin:auto;"></div>
            </figure>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navbarMenu = document.querySelector('.navbar-menu');

        mobileMenuBtn.addEventListener('click', () => {
            navbarMenu.classList.toggle('active');
        });

        // Reveal Animation
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

        window.addEventListener("load", reveal);
        window.addEventListener("scroll", reveal2);
    </script>

    <script type="text/javascript">
    var chartData = @json($dataAlternatifData);
    var chartCategories = @json($dataAlternatifNama);

    // Menggabungkan kategori dan data menjadi satu array objek
    var combinedData = chartCategories.map(function(name, index) {
        return { name: name, y: chartData[index] };
    });

    // Mengurutkan array berdasarkan nama
    combinedData.sort(function(a, b) {
        return a.name.localeCompare(b.name);
    });

    // Memisahkan kembali menjadi array terpisah untuk kategori dan data
    chartCategories = combinedData.map(function(item) { return item.name; });
    chartData = combinedData.map(function(item) { return item.y; });

    Highcharts.chart('chart1', {
        chart: {
            type: 'column',
            backgroundColor: '#FCFFC5',
            borderRadius: 10
        },
        title: {
            text: 'Hasil Perhitungan Calon Penerima Bantuan',
            align: 'center'
        },
        xAxis: {
            categories: chartCategories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nilai Akhir'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:12px; height:40px;">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color}; padding:0; text-align:center; "></td>' +
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
            data: chartData
        }]
    });
    </script>

    <script type="text/javascript">
    var chartCategories2 = @json($sepuluhTerbesarNama);
    var chartData2 = @json($sepuluhTerbesarData);
    Highcharts.chart('chart2', {
        chart: {
            type: 'column',
            backgroundColor: '#FCFFC5',
            borderRadius: 10
        },
        title: {
            text: 'Penerima Bantuan Raskin',
            align: 'center'
        },
        xAxis: {
            categories: chartCategories2,
            crosshair: true
        },
        yAxis: {
            min: 0,
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
            data: chartData2
        }]
    });
    </script>
</body>

</html>