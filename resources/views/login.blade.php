<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Title & Favicon -->
    <title>Login - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi</title>
    <link rel="shortcut icon" href="{{asset('guest/assets/images/logo.png')}}" />
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('guest/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('guest/global.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />
</head>

<body>
    <!-- Navbar Section -->
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

    <!-- Login Form Section -->
    <form method="POST" action="{{ route('login') }}" onsubmit="return validateForm()" class="login-form">
        @csrf
        <h3>Login</h3>
        
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" placeholder="Username" id="username" name="username" required autofocus>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" name="password" required>
        </div>
        
        <button type="submit">Log In</button>
    </form>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navbarMenu = document.querySelector('.navbar-menu');

        mobileMenuBtn.addEventListener('click', () => {
            navbarMenu.classList.toggle('active');
        });

        // Form Validation
        function validateForm() {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            if (username === "" || password === "") {
                alert("Username and Password must be filled out");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>