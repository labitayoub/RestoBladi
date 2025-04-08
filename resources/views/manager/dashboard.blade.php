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
                                <i class="fas fa-tachometer-alt text-orange-500 mr-2"></i>Tableau de bord
                            </h3>
                        </div>
                        
                        <!-- Welcome Section -->
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 mb-6 text-white">
                            <h2 class="text-2xl font-bold mb-2">Bienvenue, {{ Auth::user()->name }}</h2>
                            <p>Gérez votre restaurant avec facilité grâce à RestoBladi.</p>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                                        <i class="fas fa-utensils text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Menus</p>
                                        <p class="text-xl font-semibold">{{ \App\Models\Menu::count() ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-green-100 mr-4">
                                        <i class="fas fa-chair text-green-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Tables</p>
                                        <p class="text-xl font-semibold">{{ \App\Models\Table::count() ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                                        <i class="fas fa-user-tie text-purple-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Serveurs</p>
                                        <p class="text-xl font-semibold">{{ \App\Models\Waiter::count() ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Access -->
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Accès rapide</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                            <a href="{{ route('categories.index') }}" class="bg-white p-4 rounded-lg shadow text-center hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-th-list text-2xl text-orange-500 mb-2"></i>
                                <p class="text-gray-600">Catégories</p>
                            </a>
                            
                            <a href="{{ route('menus.index') }}" class="bg-white p-4 rounded-lg shadow text-center hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-utensils text-2xl text-orange-500 mb-2"></i>
                                <p class="text-gray-600">Menus</p>
                            </a>
                            
                            <a href="{{ route('tables.index') }}" class="bg-white p-4 rounded-lg shadow text-center hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-chair text-2xl text-orange-500 mb-2"></i>
                                <p class="text-gray-600">Tables</p>
                            </a>
                            
                            <a href="{{ route('waiters.index') }}" class="bg-white p-4 rounded-lg shadow text-center hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-user-tie text-2xl text-orange-500 mb-2"></i>
                                <p class="text-gray-600">Serveurs</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
