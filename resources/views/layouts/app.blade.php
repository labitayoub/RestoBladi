<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restaurant RestoBladi') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div id="app">
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-xl font-bold text-orange-600">
                                <i class="fas fa-hamburger mr-2"></i>RestoBladi
                            </a>
                        </div>

                        <!-- Primary Nav -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('welcome') }}" class="border-transparent text-gray-600 hover:text-orange-600 hover:border-orange-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Accueil
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="border-transparent text-gray-600 hover:text-orange-600 hover:border-orange-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Dashboard
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        @guest
                            <div class="flex space-x-4">
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium">
                                    Connexion
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-white bg-orange-600 hover:bg-orange-700 px-3 py-2 rounded-md text-sm font-medium">
                                        S'inscrire
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="ml-3 relative">
                                <div class="flex items-center">
                                    <span class="mr-3 text-gray-600">{{ Auth::user()->name }}</span>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="text-white bg-red-500 hover:bg-red-600 px-3 py-2 rounded-md text-sm font-medium">
                                        Déconnexion
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" 
                                class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500" 
                                aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="mobile-menu hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('welcome') }}" class="text-gray-600 hover:bg-gray-50 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                        Accueil
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:bg-gray-50 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-600 hover:bg-gray-50 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                            Connexion
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-600 hover:bg-gray-50 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                                S'inscrire
                            </a>
                        @endif
                    @else
                        <div class="px-3 py-2">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();"
                               class="text-gray-600 hover:bg-gray-50 hover:text-red-600 block px-3 py-2 rounded-md text-base font-medium">
                                Déconnexion
                            </a>
                            <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Alert Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @include('layouts.alert')
        </div>

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.querySelector('.mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <!-- External Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    
    {{-- @yield('javascript') --}}
</body>
</html>