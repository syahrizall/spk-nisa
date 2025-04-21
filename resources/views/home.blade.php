<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Pendukung Keputusan Kelayakan Penerimaan Bantuan Raskin Di Kelurahan Maleber</title>
    <link rel="shortcut icon" href="{{asset('guest/assets/images/logo.png')}}" />
    <link rel="stylesheet" href="{{asset('guest/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('guest/global.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />
</head>

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
    <div class="home">
        <article class="container reveal">
            <img class="rounded mx-auto d-block" src="{{asset('guest/assets/images/logo.png')}}" width="250px"
                height="250px">
            <h1>Sistem Pendukung Keputusan Kelayakan Penerimaan Bantuan Raskin</h1>
            <h4>Studi Kasus : Kelurahan Maleber</h4>
        </article>
    </div>
</body>

<script defer>
// Setting up the Variables
const bars = document.getElementById("nav-action");
const nav = document.getElementById("nav");

//setting up the listener
bars.addEventListener("click", barClicked, false);

//setting up the clicked Effect
function barClicked() {
    bars.classList.toggle('active');
    nav.classList.toggle('visible');
}

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

</html>