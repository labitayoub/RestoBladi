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
                                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Sale::where('waiter_id', Auth::id())->whereDate('created_at', today())->count() ?? 0 }}</p>
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
                                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Sale::where('waiter_id', Auth::id())->whereDate('created_at', today())->sum('total_ttc') ?? 0 }} DH</p>
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
                                    @php
                                        $menuCount = \App\Models\Sale::where('waiter_id', Auth::id())
                                            ->whereDate('created_at', today())
                                            ->with('menus')
                                            ->get()
                                            ->pluck('menus')
                                            ->flatten()
                                            ->count();
                                        echo $menuCount ?? 0;
                                    @endphp
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
                                    @php
                                        $tableCount = \App\Models\Sale::where('waiter_id', Auth::id())
                                            ->whereDate('created_at', today())
                                            ->with('tables')
                                            ->get()
                                            ->pluck('tables')
                                            ->flatten()
                                            ->unique('id')
                                            ->count();
                                        echo $tableCount ?? 0;
                                    @endphp
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
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $recentSales = \App\Models\Sale::where('waiter_id', Auth::id())
                                            ->where('created_at', '>=', now()->subDay())
                                            ->with(['menus', 'table'])
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();
                                    @endphp
                                    
                                    @forelse($recentSales as $sale)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $sale->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    <i class="fas fa-chair mr-1"></i>{{ $sale->table->name ?? 'N/A' }}
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
                                                    <a href="{{ route('sales.edit', $sale->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" onclick="printReceipt({{ $sale->id }})" class="text-blue-600 hover:text-blue-900">
                                                        <i class="fas fa-print"></i>
                                                    </button>
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
                            @php
                                $topMenus = \App\Models\Sale::where('waiter_id', Auth::id())
                                    ->whereDate('created_at', '>=', now()->subDays(7))
                                    ->with('menus')
                                    ->get()
                                    ->pluck('menus')
                                    ->flatten()
                                    ->groupBy('id')
                                    ->map(function ($group) {
                                        return [
                                            'title' => $group->first()->title,
                                            'count' => $group->count()
                                        ];
                                    })
                                    ->sortByDesc('count')
                                    ->take(5);
                            @endphp
                            
                            @forelse($topMenus as $menu)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">{{ $menu['title'] }}</span>
                                    <span class="font-semibold">{{ $menu['count'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-orange-500 h-2.5 rounded-full" style="width: {{ min($menu['count'] / max($topMenus->max('count'), 1) * 100, 100) }}%"></div>
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
                   
                </div>
                
                <!-- Quick Access Section -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-bolt text-orange-500 mr-2"></i>Accès rapide
                    </h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <a href="{{ route('orders.index') }}" class="flex flex-col items-center justify-center bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:border-orange-300 transition-all duration-200 hover:shadow-lg group">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600 mb-3 group-hover:bg-orange-200 transition-colors duration-200">
                                <i class="fas fa-plus-circle text-2xl"></i>
                            </div>
                            <h5 class="font-medium text-gray-700 group-hover:text-orange-600 transition-colors duration-200">Nouvelle commande</h5>
                        </a>
                        
                        <a href="{{ route('orders.index') }}#menus" class="flex flex-col items-center justify-center bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:border-orange-300 transition-all duration-200 hover:shadow-lg group">
                            <div class="p-3 rounded-full bg-amber-100 text-amber-600 mb-3 group-hover:bg-amber-200 transition-colors duration-200">
                                <i class="fas fa-utensils text-2xl"></i>
                            </div>
                            <h5 class="font-medium text-gray-700 group-hover:text-amber-600 transition-colors duration-200">Consulter menus</h5>
                        </a>
                        
                        <a href="{{ route('tables.index') }}" class="flex flex-col items-center justify-center bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:border-orange-300 transition-all duration-200 hover:shadow-lg group">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mb-3 group-hover:bg-blue-200 transition-colors duration-200">
                                <i class="fas fa-chair text-2xl"></i>
                            </div>
                            <h5 class="font-medium text-gray-700 group-hover:text-blue-600 transition-colors duration-200">Gérer tables</h5>
                        </a>
                        
                        <a href="{{ route('sales.index') }}" class="flex flex-col items-center justify-center bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:border-orange-300 transition-all duration-200 hover:shadow-lg group">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mb-3 group-hover:bg-green-200 transition-colors duration-200">
                                <i class="fas fa-receipt text-2xl"></i>
                            </div>
                            <h5 class="font-medium text-gray-700 group-hover:text-green-600 transition-colors duration-200">Historique ventes</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printReceipt(id) {
        // Create a new window
        const printWindow = window.open('', '_blank');
        
        // Fetch the receipt content
        fetch(`/sales/${id}/receipt`)
            .then(response => response.text())
            .then(html => {
                // Populate the new window with the receipt HTML
                printWindow.document.write(html);
                printWindow.document.close();
                
                // Trigger print after the content is loaded
                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                };
            })
            .catch(error => {
                console.error('Error fetching receipt:', error);
                printWindow.close();
                alert('Erreur lors de l\'impression du reçu');
            });
    }
    
    function refreshPage() {
        // Add a loading indicator
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
        overlay.style.display = 'flex';
        overlay.style.justifyContent = 'center';
        overlay.style.alignItems = 'center';
        overlay.style.zIndex = '9999';
        
        const spinner = document.createElement('div');
        spinner.innerHTML = '<i class="fas fa-spinner fa-spin fa-3x text-orange-500"></i>';
        overlay.appendChild(spinner);
        
        document.body.appendChild(overlay);
        
        // Refresh the page after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 500);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Any dashboard-specific JavaScript can go here
        
        // Set up auto-refresh (every 5 minutes)
        const REFRESH_INTERVAL = 5 * 60 * 1000; // 5 minutes
        setInterval(refreshPage, REFRESH_INTERVAL);
    });
</script>
@endsection