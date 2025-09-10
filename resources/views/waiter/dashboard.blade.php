@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-4 mb-6">
                    <div class="flex items-center mb-4 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-tachometer-alt text-orange-500 mr-2"></i>Tableau de Bord Serveur
                        </h3>
                    </div>
                    <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                        <span class="text-gray-600 text-sm bg-gray-100 px-3 py-1 rounded-full">
                            <i class="far fa-clock mr-1"></i>{{ Carbon\Carbon::now()->format('d/m/Y H:i') }}
                        </span>
                        <span class="text-gray-600 text-sm bg-blue-100 px-3 py-1 rounded-full">
                            <i class="fas fa-user-tie mr-1"></i>{{ Auth::user()->name }}
                        </span>
                    </div>
                </div>
                
                <!-- Quick Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg shadow-sm border-l-4 border-blue-500 transform transition-transform duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-600">Mes commandes (aujourd'hui)</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ $todayOrders }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg shadow-sm border-l-4 border-green-500 transform transition-transform duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-green-600">Mes ventes (DH)</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ $todaySales }} DH
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-lg shadow-sm border-l-4 border-purple-500 transform transition-transform duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 text-white mr-4">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-purple-600">Menus servis</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ $menuCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-lg shadow-sm border-l-4 border-amber-500 transform transition-transform duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-amber-500 text-white mr-4">
                                <i class="fas fa-chair"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-amber-600">Tables servies</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ $tableCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4 mb-8">
                    <a href="{{ route('orders.index') }}" class="flex items-center bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        <i class="fas fa-plus-circle mr-2"></i> Nouvelle commande
                    </a>
                    
                    <a href="#" class="flex items-center bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out" onclick="refreshPage()">
                        <i class="fas fa-sync-alt mr-2"></i> Actualiser
                    </a>
                </div>
                
                <!-- Recent Orders Section -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-history text-orange-500 mr-2"></i>Mes commandes récentes
                        <span class="ml-2 text-xs font-normal text-gray-500">(dernières 24 heures)</span>
                    </h4>
                    
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menus</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">                                    
                                    @forelse($recentSales as $sale)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $sale->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    <i class="fas fa-chair mr-1"></i>
                                                    @if($sale->tables && $sale->tables->count() > 0)
                                                        {{ $sale->tables->first()->name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <div class="flex flex-wrap gap-1 max-w-xs">
                                                    @foreach($sale->menus as $menu)
                                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                            {{ $menu->title }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                                {{ $sale->total_ttc }} DH
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($sale->payment_type === 'cash')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                        <i class="fas fa-money-bill-wave mr-1"></i>Espèce
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800">
                                                        <i class="fas fa-credit-card mr-1"></i>Carte
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $sale->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                            
                                                    <a href="{{ route('sales.show', $sale->id) }}" class="text-gray-600 hover:text-gray-900">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                                <div class="flex flex-col items-center justify-center py-6">
                                                    <i class="fas fa-clipboard-list text-3xl mb-2 text-gray-300"></i>
                                                    <p class="text-gray-500">Aucune commande récente</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Performance Analytics -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Top Menus -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h5 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-trophy text-orange-400 mr-2"></i>Vos menus les plus vendus
                        </h5>
                        <div class="space-y-3">
                            @forelse($topMenus as $menu)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">{{ $menu['title'] }}</span>
                                    <span class="font-semibold">{{ $menu['count'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-orange-500 h-2.5 rounded-full" style="width: {{ min($menu['count'] / $maxCount * 100, 100) }}%"></div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-6 text-gray-500">
                                    <i class="fas fa-chart-pie text-3xl mb-2 text-gray-300"></i>
                                    <p class="text-gray-500 text-sm">Aucune donnée disponible</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Weekly Performance -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h5 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-chart-line text-blue-400 mr-2"></i>Performance hebdomadaire
                        </h5>
                        <div class="space-y-4">
                            @foreach($dailyStats as $stat)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-medium text-gray-500">{{ $stat['day'] }} ({{ $stat['date'] }})</span>
                                        <span class="text-xs font-medium">{{ $stat['count'] }} ventes - {{ $stat['total'] }} DH</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($stat['total'] / $maxSales) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-200">
                                <span class="text-sm font-medium text-gray-600">Total hebdomadaire</span>
                                <span class="text-sm font-semibold">
                                    {{ $weeklyTotal }} DH
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Restaurant Info Section -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-store text-orange-500 mr-2"></i>Information restaurant
                    </h4>
                    
                    <div class="bg-white p-6 rounded-lg shadow">
                        @if($restaurant)
                            <div class="flex flex-col md:flex-row items-start gap-6">
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-lg border-l-4 border-orange-500 flex-1">
                                    <h5 class="text-md font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>À propos
                                    </h5>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Nom:</span> {{ $restaurant->name }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Adresse:</span> {{ $restaurant->address }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Téléphone:</span> {{ $restaurant->phone_number }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border-l-4 border-blue-500 flex-1">
                                    <h5 class="text-md font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-user-shield text-blue-500 mr-2"></i>Votre manager
                                    </h5>
                                    <div class="space-y-2">
                                        @if($manager && $manager->user)
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Nom:</span> {{ $manager->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Email:</span> {{ $manager->user->email }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500">Information non disponible</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-6 text-gray-500">
                                <i class="fas fa-store-slash text-3xl mb-2 text-gray-300"></i>
                                <p class="text-gray-500 text-sm">Information du restaurant non disponible</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction optimisée pour rafraîchir la page avec un indicateur visuel
    function refreshPage() {
        // Création d'un overlay pour l'indicateur de chargement
        const overlay = document.createElement('div');
        Object.assign(overlay.style, {
            position: 'fixed',
            top: '0',
            left: '0',
            width: '100%',
            height: '100%',
            backgroundColor: 'rgba(255, 255, 255, 0.7)',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            zIndex: '9999'
        });
        
        // Ajout de l'icône de chargement
        overlay.innerHTML = '<i class="fas fa-spinner fa-spin fa-3x text-orange-500"></i>';
        document.body.appendChild(overlay);
        
        // Rafraîchissement légèrement différé pour permettre l'affichage de l'animation
        setTimeout(() => window.location.reload(), 300);
    }
    
    // Initialisation lors du chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        // Aucune configuration d'auto-rafraîchissement
        // Le rafraîchissement se fait uniquement via le bouton d'actualisation
    });
</script>
@endsection