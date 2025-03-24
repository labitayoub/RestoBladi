<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App School | @yield('title')</title>
    <link rel="icon" href="img/icons8-book-16.png" type="image/x-icon">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navbar (directly implemented) -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="text-xl font-bold">
                    <i class="fas fa-school mr-2"></i>App School
                    </a>
                </div>
                <div class="hidden md:flex space-x-4">
                    <a href="{{ route('welcome') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Accueil</a>
                    <a href="{{ route('courses') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Cours</a>
                    <a href="{{ route('about') }}" class="hover:bg-blue-700 px-3 py-2 rounded">À propos</a>
                    <a href="{{ route('contact') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Contact</a>
                </div>
                <div class="md:hidden">
                    <button class="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden">
            <a href="{{ route('welcome') }}" class="block py-2 px-4 text-sm hover:bg-blue-700">Accueil</a>
            <a href="{{ route('courses') }}" class="block py-2 px-4 text-sm hover:bg-blue-700">Cours</a>
            <a href="{{ route('about') }}" class="block py-2 px-4 text-sm hover:bg-blue-700">À propos</a>
            <a href="{{ route('contact') }}" class="block py-2 px-4 text-sm hover:bg-blue-700">Contact</a>
        </div>
    </nav>
    
    <!-- Authentication Navigation -->
    <div class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-end">
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 mr-3">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                        <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                    <i class="fas fa-sign-in-alt mr-1"></i> Connexion
                </a>
            @endauth
        </div>
    </div>
    
    {{-- @include('components.alerts') --}}

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer (directly implemented) -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between">
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h3 class="text-xl font-bold mb-3">App School</h3>
                    <p class="mb-4">Plateforme éducative pour tous les niveaux scolaires.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-blue-400"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white hover:text-blue-400"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white hover:text-blue-400"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h3 class="text-xl font-bold mb-3">Liens rapides</h3>
                    <ul>
                        <li class="mb-2"><a href="{{ route('welcome') }}" class="hover:text-blue-400">Accueil</a></li>
                        <li class="mb-2"><a href="{{ route('courses') }}" class="hover:text-blue-400">Cours</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}" class="hover:text-blue-400">À propos</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="hover:text-blue-400">Contact</a></li>
                    </ul>
                </div>
                <div class="w-full md:w-1/3">
                    <h3 class="text-xl font-bold mb-3">Contact</h3>
                    <ul>
                        <li class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i> 123 Rue de l'École, Ville</li>
                        <li class="mb-2"><i class="fas fa-phone mr-2"></i> +1 234 567 890</li>
                        <li class="mb-2"><i class="fas fa-envelope mr-2"></i> contact@appschool.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-6 pt-6 text-center">
                <p>&copy; {{ date('Y') }} App School. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    
    <!-- Mobile menu script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.querySelector('.mobile-menu-button');
            const menu = document.querySelector('.mobile-menu');
            
            button.addEventListener('click', function() {
                menu.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>