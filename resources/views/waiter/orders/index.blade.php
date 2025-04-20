@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col">
                    <!-- Header Section - Modernized -->
                    <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-4 mb-6">
                        <div class="flex items-center mb-4 md:mb-0">
                            <a href="/dashboard" class="text-gray-500 hover:text-gray-700 mr-4 transition duration-150">
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
                                    <p class="text-2xl font-bold text-gray-800">{{$todayOrders}}</p>
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
                                    <p class="text-2xl font-bold text-gray-800">{{ $todaySales }} DH</p>
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
                            <div class="mb-4">
                                <a href="#" class="flex items-center justify-center bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-2.5 px-5 rounded-lg text-sm font-medium transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg border border-orange-600" onclick="refreshPage()">
                                    <i class="fas fa-sync-alt mr-2"></i> Actualiser les tables
                                </a>
                            </div>
                            
                            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                                <div class="p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                        @foreach ($tables as $table)
                                            @if($table->status==1)
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
                                                    @php
                                                        // Récupérer l'ID du serveur authentifié
                                                        $authWaiterId = App\Models\Waiter::where('user_id', Auth::id())->first()->id ?? 0;
                                                    @endphp
                                                    
                                                    @foreach ($table->sales as $sale)
                                                        @if ($sale->created_at >= Carbon\Carbon::today() && $sale->waiter_id == $authWaiterId)
                                                        <div class="mt-3" id="{{ $sale->id }}">
                                                            <div class="bg-white border-2 border-dashed border-pink-200 rounded-lg p-5 mx-auto max-w-xs text-center text-gray-700 transform transition hover:scale-105 duration-200">
                                                                <!-- En-tête avec nom du produit -->
                                                                <div class="mb-2">
                                                                    @foreach ($sale->menus as $menu)
                                                                        <h5 class="font-semibold text-gray-800 text-xl">
                                                                            {{ $menu->title }}
                                                                        </h5>
                                                                        <p class="text-gray-600 mb-3">
                                                                            {{ $menu->price }} DH
                                                                        </p>
                                                                    @endforeach
                                                                </div>
                                                                
                                                                <!-- Section serveur -->
                                                                <div class="mb-3">
                                                                    <span class="bg-red-500 text-white text-xs font-medium px-3 py-1 rounded">
                                                                        Serveur : {{ $sale->waiter->user->name }}
                                                                    </span>
                                                                </div>
                                                                
                                                                <!-- Date et heure de la commande -->
                                                                <div class="mb-3 text-xs">
                                                                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full">
                                                                        <i class="far fa-calendar-alt mr-1"></i>{{ $sale->created_at->format('d/m/Y H:i') }}
                                                                    </span>
                                                                </div>
                                                                
                                                                <!-- Détails de la commande -->
                                                                <div class="space-y-2 mb-4 text-sm">
                                                                    <div class="flex justify-between text-black">
                                                                        <span class="font-medium">Articles :</span>
                                                                        <span class="font-medium">{{ count($sale->menus) }}</span>
                                                                    </div>
                                                                    
                                                                    <div class="flex justify-between text-black">
                                                                        <span class="font-medium">Prix HT :</span>
                                                                        <span class="font-medium">{{ $sale->total_ht }} DH</span>
                                                                    </div>
                                                                    
                                                                    <div class="flex justify-between text-black">
                                                                        <span class="font-medium">TVA :</span>
                                                                        <span class="font-medium">{{ $sale->tva }} DH</span>
                                                                    </div>
                                                                    
                                                                    <div class="flex justify-between font-semibold text-black">
                                                                        <span>Total TTC :</span>
                                                                        <span>{{ $sale->total_ttc }} DH</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Informations de paiement -->
                                                                <div class="space-y-2 mb-4 text-sm">
                                                                    <div class="flex justify-between text-black">
                                                                        <span class="font-medium">Type de paiement :</span>
                                                                        <span class="font-medium">{{ $sale->payment_type === "cash" ? "Espèce" : "TPE" }}</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Pied de page - Information du restaurant dynamique -->
                                                                <div class="pt-3 border-t border-gray-200 text-sm text-gray-600">
                                                                    @php
                                                                        // Récupérer le restaurant via la relation serveur -> manager -> restaurant
                                                                        $restaurant = null;
                                                                        $waiter = $sale->waiter;
                                                                        
                                                                        if ($waiter) {
                                                                            // Récupérer le manager à partir de l'ID manager dans la table des serveurs
                                                                            $manager = \App\Models\Manager::find($waiter->manager_id);
                                                                            
                                                                            if ($manager) {
                                                                                // Récupérer le restaurant lié à ce manager
                                                                                $restaurant = \App\Models\Restaurant::find($manager->restaurant_id);
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    
                                                                    <!-- Message de remerciement au client -->
                                                                    <div class="mb-2 font-medium italic">
                                                                        Merci pour votre visite. Au plaisir de vous revoir très bientôt!
                                                                    </div>
                                                                    
                                                                    <div class="font-semibold">
                                                                        Restaurant {{ $restaurant ? $restaurant->name : '' }}
                                                                    </div>
                                                                    <div>{{ $restaurant ? $restaurant->address : '' }}</div>
                                                                    <div>{{ $restaurant ? $restaurant->phone_number : '' }}</div>
                                                                </div>
                                                                
                                                                <!-- Boutons d'action -->
                                                                <div class="flex justify-center mt-4 space-x-3">
                                                                    <a href="{{ route('sales.edit', $sale->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1.5 px-3 rounded-md text-xs transition duration-150 ease-in-out">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <button type="button" onclick="printReceipt({{ $sale->id }})" class="bg-blue-500 hover:bg-blue-600 text-white py-1.5 px-3 rounded-md text-xs transition duration-150 ease-in-out">
                                                                        <i class="fas fa-print"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
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
                                    <!-- Tabs Navigation - Enhanced -->
                                    <div class="border-b border-gray-200 mb-4 flex overflow-x-auto hide-scrollbar">
                                        <nav class="flex flex-nowrap -mb-px">
                                            @foreach ($categories as $category)
                                                <a 
                                                    href="#{{ $category->slug }}" 
                                                    class="inline-block py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap {{ $category->slug === 'le-petit-dejeuner' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                                                    id="{{ $category->slug }}-tab"
                                                    data-toggle="pill"
                                                    role="tab"
                                                    aria-controls="{{ $category->slug }}"
                                                    aria-selected="{{ $category->slug === 'le-petit-dejeuner' ? 'true' : 'false' }}"
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
                                                class="tab-pane {{ $category->slug === 'le-petit-dejeuner' ? 'block' : 'hidden' }}"
                                                id="{{ $category->slug }}"
                                                role="tabpanel"
                                                aria-labelledby="{{ $category->slug }}-tab"
                                            >
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @foreach ($category->menus as $menu)
                                                        <div class="bg-white rounded-lg shadow border p-4 transition duration-200 hover:shadow-lg hover:border-orange-300 h-full group menu-item" data-price="{{ $menu->price }}">
                                                            <div class="flex flex-col items-center">
                                                                <div class="flex justify-end w-full mb-2">
                                                                    <input type="checkbox" name="menu_id[]" id="menu_{{ $menu->id }}" value="{{ $menu->id }}" class="h-4 w-4 text-orange-600 menu-checkbox">
                                                                </div>
                                                                <div class="w-24 h-24 overflow-hidden rounded-full mb-3 group-hover:ring-2 ring-orange-400 transition-all duration-300">
                                                                    <img 
                                                                        src="{{ asset('images/menus/'. $menu->image) }}" 
                                                                        alt="{{ $menu->title }}"
                                                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                                    >
                                                                </div>
                                                                <h5 class="font-semibold text-lg text-gray-800 text-center menu-title">
                                                                    {{ $menu->title }}
                                                                </h5>
                                                                <p class="text-orange-600 font-bold mt-1 menu-price">
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
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <label for="total_ht" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-calculator mr-1 text-gray-500"></i>Total HT
                                                </label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">DH</span>
                                                    </div>
                                                    <input 
                                                        type="number" 
                                                        name="total_ht" 
                                                        id="total_ht"
                                                        step="0.01"
                                                        class="w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                        placeholder="0.00"
                                                        required 
                                                        readonly
                                                    >
                                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <label for="tva" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-percent mr-1 text-gray-500"></i>TVA
                                                </label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">DH</span>
                                                    </div>
                                                    <input 
                                                        type="number" 
                                                        name="tva" 
                                                        id="tva"
                                                        step="0.01"
                                                        class="w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                        placeholder="0.00"
                                                        required 
                                                        readonly
                                                    >
                                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <label for="total_ttc" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-tags mr-1 text-gray-500"></i>Total TTC
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
                                                        readonly
                                                    >
                                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label for="waiter_info" class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-user-tie mr-1 text-gray-500"></i>Serveur
                                                </label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm"><i class="fas fa-id-badge"></i></span>
                                                    </div>
                                                    <input 
                                                        type="text" 
                                                        id="waiter_info"
                                                        class="w-full pl-10 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                                        value="{{ Auth::user()->name }} "
                                                        readonly
                                                    >
                                                </div>
                                                <input type="hidden" name="waiter_id" value="{{ App\Models\Waiter::where('user_id', Auth::id())->first()->id ?? '' }}">
                                            </div>
                                        </div>
                                        
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab navigation for menu categories
            const tabLinks = document.querySelectorAll('[data-toggle="pill"]');
            tabLinks.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active classes
                    document.querySelectorAll('[data-toggle="pill"]').forEach(t => {
                        t.classList.remove('border-orange-500', 'text-orange-600');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                        t.setAttribute('aria-selected', 'false');
                    });
                    
                    // Hide all tab panes
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.add('hidden');
                        pane.classList.remove('block');
                    });
                    
                    // Activate clicked tab
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    this.classList.add('border-orange-500', 'text-orange-600');
                    this.setAttribute('aria-selected', 'true');
                    
                    // Show corresponding content
                    const tabID = this.getAttribute('href').substring(1);
                    const tabContent = document.getElementById(tabID);
                    tabContent.classList.remove('hidden');
                    tabContent.classList.add('block');
                });
            });
            
            // Table search functionality
            const tableSearch = document.getElementById('table-search');
            tableSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const tables = document.querySelectorAll('.table-item');
                
                tables.forEach(table => {
                    const tableName = table.dataset.name;
                    if (tableName.includes(searchTerm)) {
                        table.style.display = '';
                    } else {
                        table.style.display = 'none';
                    }
                });
            });
            
            // Calculate prices when menus are selected
            const menuCheckboxes = document.querySelectorAll('.menu-checkbox');
            menuCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotal);
            });
            
            function calculateTotal() {
                let totalHT = 0;
                const selectedMenus = document.querySelectorAll('.menu-checkbox:checked');
                
                selectedMenus.forEach(menu => {
                    const menuItem = menu.closest('.menu-item');
                    const price = parseFloat(menuItem.dataset.price);
                    totalHT += price;
                });
                
                // Calculate TVA (20%)
                const tva = totalHT * 0.2;
                const totalTTC = totalHT + tva;
                
                // Update form fields
                document.getElementById('total_ht').value = totalHT.toFixed(2);
                document.getElementById('tva').value = tva.toFixed(2);
                document.getElementById('total_ttc').value = totalTTC.toFixed(2);
            }
            
            // Fixed undefined function refreshPage by adding a simple implementation
    
        }
    );

        // Fonction pour imprimer le reçu de paiement
        function printReceipt(saleId) {
            // Créer une nouvelle fenêtre pour l'impression
            const printWindow = window.open('', '_blank', 'width=600,height=600');
            
            // Récupérer le contenu du reçu
            const receiptContent = document.getElementById(saleId).cloneNode(true);
            
            // Supprimer les boutons d'action
            const actionButtons = receiptContent.querySelectorAll('button, a');
            actionButtons.forEach(btn => btn.remove());
            
            // Créer le HTML pour l'impression
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Reçu de paiement</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .receipt { max-width: 300px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; }
                        .header { text-align: center; margin-bottom: 15px; }
                        .header h2 { margin: 0; color: #333; }
                        .details { margin: 15px 0; }
                        .detail-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
                        .total { font-weight: bold; margin-top: 10px; border-top: 1px dashed #000; padding-top: 10px; }
                        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #666; }
                        @media print {
                            body { padding: 0; margin: 0; }
                            .receipt { border: none; max-width: 100%; }
                        }
                    </style>
                </head>
                <body>
                    <div class="receipt">
                        <div class="header">
                            <h2>REÇU DE PAIEMENT</h2>
                            <small>${new Date().toLocaleDateString()}</small>
                        </div>
                        ${receiptContent.innerHTML}
                        <div class="footer">
                            <p>Merci pour votre visite !</p>
                        </div>
                    </div>
                    <script>
                        window.onload = function() {
                            window.print();
                            setTimeout(function() {
                                window.close();
                            }, 500);
                        };
                    <\/script>
                </body>
                </html>
            `);
            
            printWindow.document.close();
        }
        function refreshPage() {
            
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
        
        overlay.innerHTML = '<i class="fas fa-spinner fa-spin fa-3x text-orange-500"></i>';
        document.body.appendChild(overlay);
        
        setTimeout(() => {
            window.location.reload();
        }, 500);
    }
    </script>
@endsection
