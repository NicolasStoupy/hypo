<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])



</head>
<body>
@include('layouts.progress')
<div id="app">

    <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #007bff;">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand text-white fw-bold" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/home">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('gestion.index') }}">{{ __('Gestion Journalière') }}</a>
                    </li>   <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('facturier') }}">{{ __('Facturier') }}</a>
                    </li>
                    <li class="nav-item dropdown relative">
                        <!-- Dropdown Toggle Button -->
                        <a id="navbarDropdown" class="nav-link text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            Gestion
                        </a>
                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu absolute right-0 mt-2 bg-white shadow-lg rounded-lg w-48 ring-1 ring-black ring-opacity-5 focus:outline-none transition-all ease-in-out duration-150" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item block px-4 py-2 text-gray-700 hover:bg-blue-100 focus:text-blue-700 focus:bg-blue-50 transition-colors duration-200" href="{{ route('poney.index') }}">
                                   Poneys
                                </a>
                                <a class="dropdown-item block px-4 py-2 text-gray-700 hover:bg-blue-100 focus:text-blue-700 focus:bg-blue-50 transition-colors duration-200" href="{{ route('client.index') }}">
                                    Clients
                                </a>
                                <a class="dropdown-item block px-4 py-2 text-gray-700 hover:bg-blue-100 focus:text-blue-700 focus:bg-blue-50 transition-colors duration-200" href="{{ route('evenement.index') }}">
                                    Evenements
                                </a>
                                <a class="dropdown-item block px-4 py-2 text-gray-700 hover:bg-blue-100 focus:text-blue-700 focus:bg-blue-50 transition-colors duration-200" href="{{ route('facture.index') }}">
                                    Factures
                                </a>
                                <a class="dropdown-item block px-4 py-2 text-gray-700 hover:bg-blue-100 focus:text-blue-700 focus:bg-blue-50 transition-colors duration-200" href="{{ route('poney.index') }}">
                                    Auth
                                </a>

                            </li>

                        </ul>
                    </li>

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-light me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-light text-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">

        <div class="container">
            @include('layouts._formError')

            @yield('content')
        </div>

    </main>
</div>

</body>
</html>
