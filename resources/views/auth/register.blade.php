@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold text-gray-800">
                    <i class="fas fa-hamburger text-orange-500 mr-2"></i>Créer un compte RestoBladi
                </h2>
                <p class="text-gray-600 mt-2">Remplissez le formulaire ci-dessous pour créer votre compte</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6 max-w-3xl mx-auto">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informations personnelles -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4 border-b border-gray-200 pb-2">
                            <i class="fas fa-user text-orange-500 mr-2"></i>Informations personnelles
                        </h3>
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet
                            </label>
                            <input
                                id="name" 
                                name="name" 
                                type="text" 
                                autocomplete="name" 
                                required 
                                value="{{ old('name') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse E-mail
                            </label>
                            <input
                                id="email" 
                                name="email" 
                                type="email" 
                                autocomplete="email" 
                                required 
                                value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('email') border-red-500 @enderror"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe
                            </label>
                            <input
                                id="password" 
                                name="password" 
                                type="password" 
                                autocomplete="new-password" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('password') border-red-500 @enderror"
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmer le mot de passe
                            </label>
                            <input
                                id="password-confirm" 
                                name="password_confirmation" 
                                type="password" 
                                autocomplete="new-password" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                            >
                        </div>
                    </div>

                    <!-- Informations du restaurant -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4 border-b border-gray-200 pb-2">
                            <i class="fas fa-store text-orange-500 mr-2"></i>Informations du restaurant
                        </h3>
                        
                        <div class="mb-6">
                            <label for="restaurant_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom du restaurant
                            </label>
                            <input
                                id="restaurant_name" 
                                name="restaurant_name" 
                                type="text" 
                                required 
                                value="{{ old('restaurant_name') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('restaurant_name') border-red-500 @enderror"
                            >
                            @error('restaurant_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="restaurant_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse du restaurant
                            </label>
                            <input
                                id="restaurant_address" 
                                name="restaurant_address" 
                                type="text" 
                                required 
                                value="{{ old('restaurant_address') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('restaurant_address') border-red-500 @enderror"
                            >
                            @error('restaurant_address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="restaurant_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone du restaurant
                            </label>
                            <input
                                id="restaurant_phone" 
                                name="restaurant_phone" 
                                type="text" 
                                required 
                                value="{{ old('restaurant_phone') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('restaurant_phone') border-red-500 @enderror"
                            >
                            @error('restaurant_phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full md:w-auto flex justify-center py-2 px-6 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <i class="fas fa-user-plus mr-2"></i>Créer un compte
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Déjà un compte ? 
                    <a href="{{ route('login') }}" class="font-medium text-orange-600 hover:text-orange-500">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection