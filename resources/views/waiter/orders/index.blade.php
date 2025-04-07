@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col">
                    <!-- Header Section - Modernized -->
                    <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-4 mb-6">
                        <div class="flex items-center mb-4 md:mb-0">
                            <a href="/home" class="text-gray-500 hover:text-gray-700 mr-4 transition duration-150">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <h3 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-cash-register text-orange-500 mr-2"></i>Ventes & Commandes
                            </h3>
                        </div>
                        <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
                            <span class="text-gray-600 text-sm bg-gray-100 px-3 py-1 rounded-full">
                                <i class="far fa-clock mr-1"></i>{{ Carbon\Carbon::now()->format('d/m/Y H:i') }}
                            </span>
                            <a href="{{ route('sales.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                <i class="fas fa-list-ul mr-1"></i>Toutes les ventes
                            </a>
                        </div>
                    </div>
                    
                    <!-- Dashboard Stats - Enhanced -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg shadow-sm border-l-4 border-blue-500 transform transition-transform duration-300 hover:scale-105">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-600">Commandes aujourd'hui</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Sale::whereDate('created_at', today())->count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg shadow-sm border-l-4 border-green-500 transform transition-transform duration-300 hover:scale-105">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-600">Ventes totales (DH)</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Sale::whereDate('created_at', today())->sum('total_ttc') ?? 0 }} DH</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-lg shadow-sm border-l-4 border-purple-500 transform transition-transform duration-300 hover:scale-105">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-500 text-white mr-4">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-purple-600">Serveurs actifs</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Waiter::count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form id="add-sale" action="{{ route('sales.store') }}" method="post">
                        @csrf
                        
                        <!-- Tables Section - Redesigned -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-800">
                                    <i class="fas fa-chair text-orange-500 mr-2"></i>Tables disponibles
                                </h4>
                                <!-- Search for tables -->
                                <div class="relative">
                                    <input type="text" id="table-search" placeholder="Rechercher une table..." 
                                        class="px-4 py-2 pr-8 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                                <div class="p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                        @foreach ($tables as $table)
                                            <div class="bg-white rounded-lg shadow border hover:border-orange-300 p-4 transition duration-200 hover:shadow-md table-item" data-name="{{ strtolower($table->name) }}">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="font-semibold text-lg text-gray-700">{{ $table->name }}</span>
                                                    <div>
                                                        <input type="checkbox" name="table_id[]" id="table_{{ $table->id }}" value="{{ $table->id }}" class="h-4 w-4 text-orange-600">
                                                    </div>
                                                </div>
                                                
                                                <div class="flex flex-col items-center my-3">
                                                    <i class="fas fa-chair text-5xl text-gray-500 mb-3"></i>
                                                </div>
                                                
                                                <hr class="my-3">
                                                
                                                <!-- Commandes actives sur cette table -->
                                                <div>
                                                    @foreach ($table->sales as $sale)
                                                        @if ($sale->created_at >= Carbon\Carbon::today())
                                                            <div class="mt-3 p-3 border border-pink-200 rounded-lg bg-pink-50" id="{{ $sale->id }}">
                                                                <div class="bg-white rounded-lg shadow-sm p-3">
                                                                    <div class="flex flex-col items-center">
                                                                        @foreach ($sale->menus()->where("sales_id", $sale->id)->get() as $menu)
                                                                            <h5 class="font-semibold text-gray-800">
                                                                                {{ $menu->title }}
                                                                            </h5>
                                                                            <span class="text-gray-600 text-sm">
                                                                                {{ $menu->price }} DH
                                                                            </span>
                                                                        @endforeach
                                                                        
                                                                        <div class="mt-2 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                                            Serveur : {{ $sale->waiter->name }}
                                                                        </div>
                                                                        
                                                                        <div class="grid grid-cols-2 gap-2 mt-2 text-center w-full">
                                                                            <div class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                                                Qté : {{ $sale->quantity }}
                                                                            </div>
                                                                            <div class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                                                Prix : {{ $sale->total_ttc }} DH
                                                                            </div>
                                                                            <div class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                                                Total : {{ $sale->total_received }} DH
                                                                            </div>
                                                                            <div class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                                                Reste : {{ $sale->change }} DH
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="grid grid-cols-2 gap-2 mt-2 text-center w-full">
                                                                            <div class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                                                Type : {{ $sale->payment_type === "cash" ? "Espèce" : "Carte bancaire" }}
                                                                            </div>
                                                                            <div class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                                                État : <span class="{{ $sale->payment_status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                                                                                    {{ $sale->payment_status === "paid" ? "Payé" : "Impayé" }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <hr class="my-2 w-full border-gray-200">
                                                                        
                                                                        <div class="text-center text-xs text-gray-600">
                                                                            <div class="font-semibold">Restaurant XXXXX</div>
                                                                            <div>Rue afrah taza</div>
                                                                            <div>0123456789</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="flex justify-center mt-2 space-x-2">
                                                                    <a href="{{ route('sales.edit', $sale->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded-md text-xs transition duration-150 ease-in-out">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <button type="button" onclick="print({{ $sale->id }})" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded-md text-xs transition duration-150 ease-in-out">
                                                                        <i class="fas fa-print"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu Selection Section - Improved -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-utensils text-orange-500 mr-2"></i>Sélection de menus
                            </h4>
                            
                            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                                <div class="p-4">
                                    <!-- Search for menus -->
                                    <div class="mb-4">
                                        <div class="relative">
                                            <input type="text" id="menu-search" placeholder="Rechercher un menu..." 
                                                class="w-full px-4 py-2 pr-8 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <i class="fas fa-search text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tabs Navigation - Enhanced -->
                                    <div class="border-b border-gray-200 mb-4 flex overflow-x-auto hide-scrollbar">
                                        <nav class="flex flex-nowrap -mb-px">
                                            @foreach ($categories as $category)
                                                <a 
                                                    href="#{{ $category->slug }}" 
                                                    class="inline-block py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap {{ $category->slug === 'salades-marocaines' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                                                    id="{{ $category->slug }}-tab"
                                                    data-toggle="pill"
                                                    role="tab"
                                                    aria-controls="{{ $category->slug }}"
                                                    aria-selected="{{ $category->slug === 'salades-marocaines' ? 'true' : 'false' }}"
                                                >
                                                    <i class="fas fa-utensils mr-1 text-xs"></i>{{ $category->title }}
                                                </a>
                                            @endforeach
                                        </nav>
                                    </div>
                                    
                                    <!-- Tabs Content - Redesigned -->
                                    <div class="tab-content">
                                        @foreach ($categories as $category)
                                            <div 
                                                class="tab-pane {{ $category->slug === 'salades-marocaines' ? 'block' : 'hidden' }}"
                                                id="{{ $category->slug }}"
                                                role="tabpanel"
                                                aria-labelledby="{{ $category->slug }}-tab"
                                            >
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @foreach ($category->menus as $menu)
                                                        <div class="bg-white rounded-lg shadow border p-4 transition duration-200 hover:shadow-lg hover:border-orange-300 h-full group">
                                                            <div class="flex flex-col items-center">
                                                                <div class="flex justify-end w-full mb-2">
                                                                    <input type="checkbox" name="menu_id[]" id="menu_{{ $menu->id }}" value="{{ $menu->id }}" class="h-4 w-4 text-orange-600">
                                                                </div>
                                                                <div class="w-24 h-24 overflow-hidden rounded-full mb-3 group-hover:ring-2 ring-orange-400 transition-all duration-300">
                                                                    <img 
                                                                        src="{{ asset('images/menus/'. $menu->image) }}" 
                                                                        alt="{{ $menu->title }}"
                                                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                                    >
                                                                </div>
                                                                <h5 class="font-semibold text-lg text-gray-800 text-center">
                                                                    {{ $menu->title }}
                                                                </h5>
                                                                <p class="text-orange-600 font-bold mt-1">
                                                                    {{ $menu->price }} DH
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>                       
                        <!-- Order Information Section - Redesigned -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-file-invoice text-orange-500 mr-2"></i>Détails de la commande
                            </h4>
                            
                            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                                <div class="p-4">
                                    <div class="max-w-md mx-auto space-y-4">
                                        <div class="mb-4">
                                            <label for="waiter_id" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-user-tie mr-1 text-gray-500"></i>Sérveur
                                            </label>
                                            <select 
                                                name="waiter_id" 
                                                id="waiter_id"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                required
                                            >
                                                <option value="" selected disabled>Choisir un sérveur</option>
                                                @foreach ($waiters as $waiter)
                                                    <option value="{{ $waiter->id }}">{{ $waiter->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-sort-amount-up mr-1 text-gray-500"></i>Quantité
                                                </label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">Qté</span>
                                                    </div>
                                                    <input 
                                                        type="number" 
                                                        name="quantity" 
                                                        id="quantity"
                                                        class="w-full pl-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                        placeholder="0"
                                                        required
                                                    >
                                                </div>
                                            </div>
                                            <div>
                                                <label for="total_ttc" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-tag mr-1 text-gray-500"></i>Prix
                                                </label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">DH</span>
                                                    </div>
                                                    <input 
                                                        type="number" 
                                                        name="total_ttc" 
                                                        id="total_ttc"
                                                        step="0.01"
                                                        class="w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                        placeholder="0.00"
                                                        required 
                                                    >
                                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="total_received" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-money-bill-alt mr-1 text-gray-500"></i>Total reçu
                                                </label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">DH</span>
                                                    </div>
                                                    <input 
                                                        type="number" 
                                                        name="total_received" 
                                                        id="total_received"
                                                        step="0.01"
                                                        class="w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                        placeholder="0.00"
                                                        required 
                                                    >
                                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="change" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-exchange-alt mr-1 text-gray-500"></i>Monnaie à rendre
                                                </label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">DH</span>
                                                    </div>
                                                    <input 
                                                        type="number" 
                                                        name="change" 
                                                        id="change"
                                                        step="0.01"
                                                        class="w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                        placeholder="0.00"
                                                    >
                                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-credit-card mr-1 text-gray-500"></i>Type de paiement
                                                </label>
                                                <select 
                                                    name="payment_type" 
                                                    id="payment_type"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                    required
                                                >
                                                    <option value="" selected disabled>Choisir un type de paiement</option>
                                                    <option value="cash">Espèce</option>
                                                    <option value="card">Carte bancaire</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-check-circle mr-1 text-gray-500"></i>État de paiement
                                                </label>
                                                <select 
                                                    name="payment_status" 
                                                    id="payment_status"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                    required
                                                >
                                                    <option value="" selected disabled>Choisir un état de paiement</option>
                                                    <option value="paid">Payé</option>
                                                    <option value="unpaid">Impayé</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-center mt-6">
                                            <button 
                                                type="submit"
                                                class="bg-orange-600 hover:bg-orange-700 text-white py-3 px-6 rounded-md text-sm font-medium transition duration-150 ease-in-out w-full md:w-auto"
                                            >
                                                <i class="fas fa-check-circle mr-1"></i> Valider la commande
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Daily Statistics - Enhanced -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-chart-bar text-orange-500 mr-2"></i>Statistiques du jour
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white p-6 rounded-lg shadow">
                                    <h5 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                                        <i class="fas fa-trophy text-orange-400 mr-2"></i>Menus les plus vendus
                                    </h5>
                                    <div class="space-y-3">
                                        @php
                                            $topMenus = \App\Models\Sale::with('menus')
                                                ->whereDate('created_at', today())
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
                                <div class="bg-white p-6 rounded-lg shadow">
                                    <h5 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                                        <i class="fas fa-user-check text-green-500 mr-2"></i>Performances des serveurs
                                    </h5>
                                    <div class="space-y-3">
                                        @php
                                            $waiterPerformance = \App\Models\Sale::with('waiter')
                                                ->whereDate('created_at', today())
                                                ->get()
                                                ->groupBy('waiter_id')
                                                ->map(function ($group) {
                                                    return [
                                                        'name' => $group->first()->waiter->name,
                                                        'count' => $group->count(),
                                                        'total' => $group->sum('total_ttc')
                                                    ];
                                                })
                                                ->sortByDesc('total')
                                                ->take(5);
                                        @endphp
                                        
                                        @forelse($waiterPerformance as $waiter)
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">{{ $waiter['name'] }}</span>
                                                <span class="font-semibold">{{ $waiter['total'] }} DH</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ min($waiter['total'] / max($waiterPerformance->max('total'), 1) * 100, 100) }}%"></div>
                                            </div>
                                        @empty
                                            <div class="flex flex-col items-center justify-center py-6 text-gray-500">
                                                <i class="fas fa-chart-pie text-3xl mb-2 text-gray-300"></i>
                                                <p class="text-gray-500 text-sm">Aucune donnée disponible</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
   