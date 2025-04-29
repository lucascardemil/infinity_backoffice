<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Administración Inversiones Infinity') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>

<body>
    <header class="navbar navbar-dv sticky-top d-flex py-0 shadow">

        <a class="navbar-brand col-md-3 col-lg-2 me-0 text-center" href="#">
            <img src="/images/logo.png" alt="Inversiones Infinity" class="img-dashboard">
        </a>
        <button class="navbar-toggler bg-light d-md-none m-3 collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <div class="d-flex justify-content-center align-items-center px-3">
                    <div class="text-white fw-bold">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-white px-3">
                        |
                    </div>
                    <div>
                        <a class="btn btn-base-dv" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                 document.getElementById('logout-form-desktop').submit();">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesion
                        </a>
                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky mt-3">
                    <ul class="nav navbar-dv flex-column">
                        @can('propiedad')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.propiedad.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.propiedad.index') }}">
                                    <i class="bi bi-house-add-fill"></i>
                                    Administracion Propiedad
                                </a>
                            </li>
                        @endcan
                        @can('atributo_adicional')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.atributo_adicional.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.atributo_adicional.index') }}">
                                    <i class="bi bi-list-ul"></i>
                                    Atributos Adicionales
                                </a>
                            </li>
                        @endcan
                        @can('categoria_secundaria')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.categoria_secundaria.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.categoria_secundaria.index') }}">
                                    <i class="bi bi-bookmark-fill"></i>
                                    Categorias Secundarias
                                </a>
                            </li>
                        @endcan
                        @can('ubicacion')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.ubicacion.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.ubicacion.index') }}">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    Regiones y Ciudades
                                </a>
                            </li>
                        @endcan
                        @can('formato_negocio')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.formato_negocio.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.formato_negocio.index') }}">
                                    <i class="bi bi-briefcase-fill"></i>
                                    Formatos Negocios
                                </a>
                            </li>
                        @endcan
                        @can('tipo_propiedad')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.tipo_propiedad.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.tipo_propiedad.index') }}">
                                    <i class="bi bi-house-fill"></i>
                                    Tipos Propiedades
                                </a>
                            </li>
                        @endcan
                        @can('roles')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}" aria-current="page"
                                    href="{{ route('admin.roles.index') }}">
                                    <i class="bi bi-person-fill-gear"></i>
                                    Roles
                                </a>
                            </li>
                        @endcan
                        @can('usuarios')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.usuarios.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.usuarios.index') }}">
                                    <i class="bi bi-person-add"></i>
                                    Usuarios
                                </a>
                            </li>
                        @endcan
                        @can('configuraciones')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.configuraciones.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.configuraciones.index') }}">
                                    <i class="bi bi-gear-fill"></i>
                                    Configuraciones
                                </a>
                            </li>
                        @endcan
                        @can('clientes')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.clientes.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('admin.clientes.index') }}">
                                    <i class="bi bi-person-fill-exclamation"></i>
                                    Clientes
                                </a>
                            </li>
                        @endcan
                        <div class="perfil-mobile">
                            <hr class="my-3">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page">
                                    <i class="bi bi-person-badge-fill"></i>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                     document.getElementById('logout-form-mobile').submit();">
                                    <i class="bi bi-door-open"></i> Cerrar Sesion
                                </a>
                                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </div>
                    </ul>
                </div>
            </nav>

            <div class="col-md-9 ms-sm-auto col-lg-10 p-4" id="app">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
