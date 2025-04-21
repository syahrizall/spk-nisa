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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{asset('admin/images/logo.png')}}" />
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

.kriteria ul {
    width: min(100%, 60rem);
    overflow: hidden;
    margin-inline: auto;
    padding-inline: clamp(1rem, 5vw, 4rem);
    list-style: none;
    perspective: 1000px;
    display: grid;
    row-gap: 0.5rem;
    margin-bottom: 50px;
}

.kriteria ul li.card {
    position: relative;
    padding-block: 1.5rem;
    padding-inline: 2rem;
    background-color: var(--bg-color);
    background-image: linear-gradient(to right, rgb(0 0 0 / .15), transparent);
    transform-style: preserve-3d;
    color: var(--color);
    display: grid;
    grid-template: 'icon''title''content';
    row-gap: 0.5rem;
    column-gap: 2rem;
}

.kriteria ul li.card::before,
.kriteria ul li.card::after {
    --side-rotate: 60deg;
    content: "";
    position: absolute;
    top: 0;
    height: 100%;
    width: 100%;
    transform-origin: calc(50% - (50% * var(--ry))) 50%;
    transform: rotateY(calc(var(--side-rotate) * var(--ry)));
    background-color: inherit;
    background-image: linear-gradient(calc(90deg * var(--ry)), rgb(0 0 0 / .25), rgb(0 0 0 / .5));
}

.kriteria ul li.card::before {
    --ry: -1;
    right: 100%
}

.kriteria ul li.card::after {
    --ry: 1;
    left: 100%
}

.kriteria ul li.card .icon {
    grid-area: icon;
    display: grid;
    place-items: center;
}

.kriteria ul li.card .icon i {
    font-size: 2rem;
}

.kriteria ul li.card .title {
    grid-area: title;
    font-size: 1.25rem;
    font-weight: 700;
    text-align: center;
}

.kriteria ul li.card .content {
    grid-area: content;
}

@media (min-width: 30rem) {
    .kriteria ul li.card {
        grid-template: 'icon title''icon content';
        text-align: left;
    }

    .kriteria ul li.card .title {
        text-align: left
    }
}
</style>

<body>
    <!--HamBurger Icon-->
    <div class="bars" id="nav-action">
        <span class="bar"> </span>
    </div>

    <!--Navbar Links-->
    <nav id="nav">
        <ul>
            <li class="shape-circle circle-two">
                @if(auth()->user())
                <a href="{{url('/dashboard')}}">Dashboard</a>
                @else
                <a href="{{url('/login')}}">Login</a>
                @endif
            </li>
            <li class="shape-circle circle-three"><a href="{{url('/kriteria')}}">Kriteria</a></li>
            <li class="shape-circle circle-three"><a href="{{url('/calculation')}}">Calculation</a></li>
            <li class="shape-circle circle-five"><a href="/">Home</a></li>
        </ul>
    </nav>

    <!--Main Body Content-->
    <div class="container">
        <div class="row kriteria reveal">
            <h1 class="text-center">BOBOT KRITERIA PENERIMAAN BANTUAN</h1>
            <hr />
            <ul class="mt-4">
                <li class="card" style="--color:#ececec; --bg-color:#b3953c">
                    <div class="icon"><i class="fa-solid fa-money-bill"></i></div>
                    <div class="title">C1 - Tingkat Pendapatan</div>
                    <div class="content text-justify">Tingkat Pendapatan merujuk pada jumlah total penghasilan yang diperoleh oleh kepala keluarga atau anggota keluarga utama dalam satu bulan. Kriteria ini penting untuk menilai kemampuan ekonomi keluarga dalam memenuhi kebutuhan sehari-hari. Semakin rendah pendapatan keluarga, semakin besar kemungkinan mereka membutuhkan bantuan, seperti bantuan beras, untuk memenuhi kebutuhan dasar mereka.</div>
                </li>
                <li class="card" style="--color:#ececec; --bg-color:#2c2c2c">
                    <div class="icon"><i class="fa-solid fa-user-group"></i></div>
                    <div class="title">C2 - Jumlah Anggota Keluarga</div>
                    <div class="content text-justify">Jumlah Anggota Keluarga mencakup seluruh individu yang tinggal serumah dan menjadi tanggungan kepala keluarga. Kriteria ini digunakan untuk memahami beban tanggungan yang harus dipenuhi oleh kepala keluarga. Keluarga dengan lebih banyak anggota cenderung memerlukan bantuan lebih banyak karena lebih banyak mulut yang harus diberi makan dan lebih banyak kebutuhan yang harus dipenuhi.</div>
                </li>
                <li class="card" style="--color:#ececec; --bg-color:#3b3b3b">
                    <div class="icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="title">C3 - Status Pekerjaan</div>
                    <div class="content text-justify">Status Pekerjaan menunjukkan jenis pekerjaan atau sumber penghasilan utama yang dimiliki oleh kepala keluarga atau anggota keluarga utama. Kriteria ini mencakup kategori seperti pekerja tetap, pekerja kontrak, pekerja harian, atau tidak bekerja. Keluarga dengan status pekerjaan yang kurang stabil atau yang tidak bekerja biasanya berada dalam kondisi ekonomi yang lebih rentan dan lebih memerlukan bantuan untuk memenuhi kebutuhan dasar mereka.</div>
                </li>
                <li class="card" style="--color:#ececec; --bg-color:#535353">
                    <div class="icon"><i class="fa-solid fa-house"></i></i></i></div>
                    <div class="title">C4 - Kondisi Rumah</div>
                    <div class="content text-justify">Kondisi Rumah mencerminkan keadaan fisik tempat tinggal keluarga, termasuk jenis dan kualitas bangunan. Kriteria ini menilai apakah rumah tersebut permanen, semi permanen, atau tidak permanen serta kondisi rumah apakah baik, kurang baik, atau buruk. Kondisi rumah yang lebih buruk menunjukkan kebutuhan yang lebih besar untuk mendapatkan bantuan, karena rumah yang kurang layak huni dapat meningkatkan risiko kesehatan dan keselamatan bagi penghuni.</div>
                </li>
                <li class="card" style="--color:#ececec; --bg-color:#032437">
                    <div class="icon"><i class="fa-solid fa-notes-medical"></i></div>
                    <div class="title">C5 - Kondisi Kesehatan</div>
                    <div class="content text-justify">Kondisi Kesehatan menilai keadaan kesehatan keseluruhan anggota keluarga, termasuk ada atau tidaknya penyakit kronis, penyakit berat, atau disabilitas. Kriteria ini penting untuk menilai kebutuhan bantuan tambahan bagi keluarga yang memiliki anggota dengan kondisi kesehatan yang buruk. Keluarga dengan anggota yang menderita penyakit kronis atau disabilitas cenderung memerlukan dukungan ekstra, termasuk bantuan beras, untuk memastikan mereka dapat memenuhi kebutuhan gizi dan perawatan kesehatan yang diperlukan.</div>
                </li>
            </ul>
        </div>
    </div>

</body>

<script defer>
// Setting up the Variables
var bars = document.getElementById("nav-action");
var nav = document.getElementById("nav");


//setting up the listener
bars.addEventListener("click", barClicked, false);


//setting up the clicked Effect
function barClicked() {
    bars.classList.toggle('active');
    nav.classList.toggle('visible');
}

function reveal() {
    var reveals = document.querySelectorAll(".reveal");

    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 0;

        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
        } else {
            reveals[i].classList.remove("active");
        }
    }
}

window.addEventListener("load", reveal);
</script>

</html>