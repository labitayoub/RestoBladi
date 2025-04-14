@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <!-- Sidebar -->
                    <div class="w-full md:w-1/3 lg:w-1/4 mb-6 md:mb-0 md:pr-6">
                        @include('layouts.sidebar')
                    </div>
                    
                    <!-- Main Content -->
                    <div class="w-full md:w-2/3 lg:w-3/4">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-xl font-semibold text-gray-700">
                                <i class="fas fa-cog text-orange-500 mr-2"></i>Paramètres du compte
                            </h3>
                        </div>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif
                        
                        <!-- Profile Settings -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Information du profil</h4>
                                
                                <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    @if(Auth::user()->role_id == 2 && Auth::user()->manager)
                                    <div>
                                        <label for="restaurant_name" class="block text-sm font-medium text-gray-700">Nom du restaurant</label>
                                        <input type="text" name="restaurant_name" id="restaurant_name" value="{{ Auth::user()->manager->restaurant->name ?? '' }}" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('restaurant_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="restaurant_address" class="block text-sm font-medium text-gray-700">Adresse du restaurant</label>
                                        <textarea name="restaurant_address" id="restaurant_address" rows="3" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ Auth::user()->manager->restaurant->address ?? '' }}</textarea>
                                        @error('restaurant_address')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="restaurant_phone" class="block text-sm font-medium text-gray-700">Téléphone du restaurant</label>
                                        <input type="text" name="restaurant_phone" id="restaurant_phone" value="{{ Auth::user()->manager->restaurant->phone_number ?? '' }}" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('restaurant_phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                            Mettre à jour le profil
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Password Settings -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Changer le mot de passe</h4>
                                
                                <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                        <input type="password" name="current_password" id="current_password" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('current_password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                        <input type="password" name="password" id="password" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                            Mettre à jour le mot de passe
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection