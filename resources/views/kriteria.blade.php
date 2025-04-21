<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kriteria - Sistem Pendukung Keputusan Kelayakan Penerimaan Bantuan Raskin Di Kelurahan Maleber</title>
    <link rel="shortcut icon" href="{{asset('guest/assets/images/logo.png')}}" />
    <link rel="stylesheet" href="{{asset('guest/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('guest/global.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />
</head>

<style>
@import url('https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css');

.kriteria h1 {
    margin-top: 80px;
    color: white;
}

.kriteria hr {
    color: white;
}
</style>

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
    <div class="container">
        <div class="row kriteria reveal">
            <h1 class="text-center">BOBOT KRITERIA PENERIMAAN BANTUAN</h1>
            <hr />
            <ul class="mt-4">
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-money-bill"></i></div>
                    <div class="card-content">
                        <div class="title">C1 - Tingkat Pendapatan</div>
                        <div class="content">Tingkat Pendapatan merujuk pada jumlah total penghasilan yang diperoleh oleh kepala keluarga atau anggota keluarga utama dalam satu bulan. Kriteria ini penting untuk menilai kemampuan ekonomi keluarga dalam memenuhi kebutuhan sehari-hari.</div>
                    </div>
                </li>
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-user-group"></i></div>
                    <div class="card-content">
                        <div class="title">C2 - Jumlah Anggota Keluarga</div>
                        <div class="content">Jumlah Anggota Keluarga mencakup seluruh individu yang tinggal serumah dan menjadi tanggungan kepala keluarga. Kriteria ini digunakan untuk memahami beban tanggungan yang harus dipenuhi oleh kepala keluarga. Keluarga dengan lebih banyak anggota cenderung memerlukan bantuan lebih banyak karena lebih banyak mulut yang harus diberi makan dan lebih banyak kebutuhan yang harus dipenuhi.</div>
                    </div>
                </li>
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="card-content">
                        <div class="title">C3 - Status Pekerjaan</div>
                        <div class="content">Status Pekerjaan menunjukkan jenis pekerjaan atau sumber penghasilan utama yang dimiliki oleh kepala keluarga atau anggota keluarga utama. Kriteria ini mencakup kategori seperti pekerja tetap, pekerja kontrak, pekerja harian, atau tidak bekerja. Keluarga dengan status pekerjaan yang kurang stabil atau yang tidak bekerja biasanya berada dalam kondisi ekonomi yang lebih rentan dan lebih memerlukan bantuan untuk memenuhi kebutuhan dasar mereka.</div>
                    </div>
                </li>
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-house"></i></div>
                    <div class="card-content">
                        <div class="title">C4 - Kondisi Rumah</div>
                        <div class="content">Kondisi Rumah mencerminkan keadaan fisik tempat tinggal keluarga, termasuk jenis dan kualitas bangunan. Kriteria ini menilai apakah rumah tersebut permanen, semi permanen, atau tidak permanen serta kondisi rumah apakah baik, kurang baik, atau buruk. Kondisi rumah yang lebih buruk menunjukkan kebutuhan yang lebih besar untuk mendapatkan bantuan, karena rumah yang kurang layak huni dapat meningkatkan risiko kesehatan dan keselamatan bagi penghuni.</div>
                    </div>
                </li>
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-notes-medical"></i></div>
                    <div class="card-content">
                        <div class="title">C5 - Kondisi Kesehatan</div>
                        <div class="content">Kondisi Kesehatan menilai keadaan kesehatan keseluruhan anggota keluarga, termasuk ada atau tidaknya penyakit kronis, penyakit berat, atau disabilitas. Kriteria ini penting untuk menilai kebutuhan bantuan tambahan bagi keluarga yang memiliki anggota dengan kondisi kesehatan yang buruk. Keluarga dengan anggota yang menderita penyakit kronis atau disabilitas cenderung memerlukan dukungan ekstra, termasuk bantuan beras, untuk memastikan mereka dapat memenuhi kebutuhan gizi dan perawatan kesehatan yang diperlukan.</div>
                    </div>
                </li>
            </ul>
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

        window.addEventListener("load", reveal);
        window.addEventListener("scroll", reveal);
    </script>
</body>

</html>