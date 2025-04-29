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
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="/images/logo.png" alt="Inversiones Infinity" class="img-dashboard">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bold active" href="/">Inicio</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main id="app">
        @yield('content')
    </main>
    <footer class="bg-dark mt-5 border-top">
        <div class="container py-5">
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col-lg-4 col-md-12">
                    <a href="/" class="d-flex mb-3 link-dark text-decoration-none">
                        <img src="/images/logo.png" alt="Inversiones Infinity" width="200">
                    </a>
                    <p class="text-white">
                        Somos una empresa de gestión y asesoría inmobiliaria con sede en la ciudad de La Serena. Equipo
                        profesional dedicado a entregar un servicio de excelencia respaldado en su experiencia en el
                        mercado inmobiliario. Contáctenos
                    </p>
                </div>

                <div class="col-lg-4 col-md-12 align-self-center mb-4">
                    <div class="d-flex justify-content-lg-center">
                        <div>
                            <h3 class="texto-titulo">Link de Interés</h3>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a href="https://cbrls.cl/" class="nav-link link-interes p-0 text-white">
                                        Conservador de Bienes Raices
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="http://homer.sii.cl/" class="nav-link link-interes p-0 text-white">
                                        Servicio Impuestos Internos
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="https://www.ine.cl/" class="nav-link link-interes p-0 text-white">
                                        Instituto Nacional de Estadísticas
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="https://www.google.cl/maps" class="nav-link link-interes p-0 text-white">
                                        Google Map
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 align-self-center mb-4">
                    <div class="d-flex justify-content-lg-center">
                        <div>
                            <h3 class="texto-titulo">Contáctenos</h3>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2 text-white">Los Carrera 242, La Serena</li>
                                <li class="nav-item mb-2 text-white">Santiago Apóstol 4223, La Serena</li>
                                <li class="nav-item mb-2 text-white">+569 81997643</li>
                                <li class="nav-item mb-2 text-white">+569 81997643</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-creador py-4">
            <div class="container">
                <div class="row justify-content-center text-center text-white">
                    <div class="col-12 mb-3">@2025</div>
                    <div class="col-12">
                        <div class="d-flex justify-content-center gap-4">
                            <a href="https://web.facebook.com/people/Inmobiliaria-Infinity/61550294184813/"
                                class="bi bi-facebook fs-1 link-redes-sociales text-white"></a>
                            <a href="https://www.instagram.com/infinity.inversiones/"
                                class="bi bi-instagram fs-1 link-redes-sociales text-white"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </footer>
</body>

</html>
