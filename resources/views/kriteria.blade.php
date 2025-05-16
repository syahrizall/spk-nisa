<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kriteria - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('guest/assets/images/logo.png')}}" />
    
    <!-- CSS -->
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
            <h1 class="text-center">BOBOT KRITERIA PEMILIHAN SISWA</h1>
            <hr />
            <ul class="mt-4">
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-person-walking"></i></div>
                    <div class="card-content">
                        <div class="title">C1 - Wiraga (Gerak)</div>
                        <div class="content">Wiraga adalah unsur tari yang menekankan pada keindahan dan ketepatan gerak tubuh penari. Gerakan harus luwes, kuat, dan sesuai dengan teknik atau pakem tari yang dibawakan.</div>
                    </div>
                </li>
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-water"></i></div>
                    <div class="card-content">
                        <div class="title">C2 - Wirama (Irama)</div>
                        <div class="content">Wirama adalah kesesuaian gerak tari dengan irama musik atau ketukan iringan. Penari harus mampu menyesuaikan tempo gerakan dengan perubahan dinamika musik.</div>
                    </div>
                </li>
                <li class="card">
                    <div class="icon"><i class="fa-solid fa-ear-listen"></i></div>
                    <div class="card-content">
                        <div class="title">C3 - Wirasa (Rasa)</div>
                        <div class="content">Wirasa adalah penjiwaan dan ekspresi yang ditampilkan oleh penari agar makna tari terasa oleh penonton. Emosi dan karakter harus disampaikan melalui ekspresi wajah dan gerakan tubuh.</div>
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