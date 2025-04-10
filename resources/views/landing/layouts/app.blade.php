<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Administración Inversiones Infinity') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/landing.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/logo.png" alt="Inversiones Infinity" class="img-dashboard">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link fs-5 fw-bold active" href="#">Inicio</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/images/FONDO.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-flex justify-content-center align-items-center">
                    <div class="bg-dark p-2 text-white bg-opacity-75">
                        <h1 class="display-5 fw-bold">Búsqueda de Bienes Raíces</h1>
                        <p class="fs-3">INFINITY, pone a disposición su Plataforma Comercial para la Compra, Venta o Arriendo de un Bien Raíz. Sean estas para fines Comerciales, Productivos o Habitacionales.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/images/FONDO-2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-flex justify-content-center align-items-center">
                    <div class="bg-dark p-2 text-white bg-opacity-75">
                        <h1 class="display-5 fw-bold">Búsqueda de Bienes Raíces</h1>
                        <p class="fs-3">INFINITY, pone a disposición su Plataforma Comercial para la Compra, Venta o Arriendo de un Bien Raíz. Sean estas para fines Comerciales, Productivos o Habitacionales.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/images/FONDO-3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-flex justify-content-center align-items-center">
                    <div class="bg-dark p-2 text-white bg-opacity-75">
                        <h1 class="display-5 fw-bold">Búsqueda de Bienes Raíces</h1>
                        <p class="fs-3">INFINITY, pone a disposición su Plataforma Comercial para la Compra, Venta o Arriendo de un Bien Raíz. Sean estas para fines Comerciales, Productivos o Habitacionales.</p>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="container-fluid">
                <div id="app">
                    @yield('content')
                </div>
            </div>
</body>

</html>
