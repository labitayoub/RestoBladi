@extends('layouts.app')

@section("content")
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form id="edit-sale" action="{{ route('sales.update', $sale->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <!-- Header Section -->
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                        <div class="flex items-center">
                            <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 transition duration-150">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <h3 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-edit text-orange-500 mr-2"></i>Modification de la commande #{{ $sale->id }}
                            </h3>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600 text-sm bg-gray-100 px-3 py-1 rounded-full">
                                <i class="far fa-clock mr-1"></i>{{ $sale->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>

                    <!-- Tables Selection -->
                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-chair text-orange-500 mr-2"></i>Tables
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($tables as $table)
                                <div class="bg-white rounded-lg shadow border p-4 transition duration-200 hover:shadow-lg hover:border-orange-300">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold text-lg text-gray-700">{{ $table->name }}</span>
                                        <input 
                                            type="checkbox" 
                                            name="table_id[]" 
                                            value="{{ $table->id }}" 
                                            class="h-4 w-4 text-orange-600"
                                            {{ in_array($table->id, $sale->tables->pluck('id')->toArray()) ? 'checked' : '' }}
                                        >
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-chair text-4xl text-gray-500 mb-2"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Menus Selection -->
                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-utensils text-orange-500 mr-2"></i>Menus
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($menus as $menu)
                                <div class="bg-white rounded-lg shadow border p-4 transition duration-200 hover:shadow-lg hover:border-orange-300">
                                    <div class="flex justify-between items-center mb-2">
                                        <input 
                                            type="checkbox" 
                                            name="menu_id[]" 
                                            value="{{ $menu->id }}" 
                                            class="h-4 w-4 text-orange-600 menu-checkbox"
                                            data-price="{{ $menu->price }}"
                                            {{ in_array($menu->id, $sale->menus->pluck('id')->toArray()) ? 'checked' : '' }}
                                        >
                                        <img 
                                            src="{{ asset('images/menus/' . $menu->image) }}" 
                                            alt="{{ $menu->title }}" 
                                            class="w-16 h-16 rounded-full object-cover"
                                        >
                                    </div>
                                    <div class="text-center">
                                        <h5 class="font-semibold text-gray-800">{{ $menu->title }}</h5>
                                        <p class="text-orange-600 font-bold">{{ $menu->price }} DH</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-file-invoice text-orange-500 mr-2"></i>Détails de la commande
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="total_ht" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calculator mr-1 text-gray-500"></i>Total HT
                                </label>
                                <input 
                                    type="number" 
                                    name="total_ht" 
                                    id="total_ht"
                                    step="0.01"
                                    value="{{ $sale->total_ht }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                    readonly
                                >
                            </div>

                            <div>
                                <label for="tva" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-percent mr-1 text-gray-500"></i>TVA
                                </label>
                                <input 
                                    type="number" 
                                    name="tva" 
                                    id="tva"
                                    step="0.01"
                                    value="{{ $sale->tva }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                    readonly
                                >
                            </div>

                            <div>
                                <label for="total_ttc" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tags mr-1 text-gray-500"></i>Total TTC
                                </label>
                                <input 
                                    type="number" 
                                    name="total_ttc" 
                                    id="total_ttc"
                                    step="0.01"
                                    value="{{ $sale->total_ttc }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                    readonly
                                >
                            </div>

                            <div>
                                <label for="waiter_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user-tie mr-1 text-gray-500"></i>Serveur
                                </label>
                                <input 
                                    type="text" 
                                    id="waiter_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                    value="{{ $currentWaiter->user->name }}"
                                    readonly
                                >
                                <input type="hidden" name="waiter_id" value="{{ $currentWaiter->id }}">
                            </div>

                            <div>
                                <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-credit-card mr-1 text-gray-500"></i>Type de paiement
                                </label>
                                <select 
                                    name="payment_type" 
                                    id="payment_type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                >
                                    <option value="cash" {{ $sale->payment_type == 'cash' ? 'selected' : '' }}>Espèce</option>
                                    <option value="card" {{ $sale->payment_type == 'card' ? 'selected' : '' }}>Carte bancaire</option>
                                </select>
                            </div>

                    
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 mt-6">
                        <a 
                            href="{{ route('orders.index') }}" 
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md transition duration-150 ease-in-out"
                        >
                            Annuler
                        </a>
                        <button 
                            type="submit" 
                            class="bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out"
                        >
                            Mettre à jour
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuCheckboxes = document.querySelectorAll('.menu-checkbox');
            const totalHTInput = document.getElementById('total_ht');
            const tvaInput = document.getElementById('tva');
            const totalTTCInput = document.getElementById('total_ttc');

            // Fixed calculation logic to ensure accurate totals
            function calculateTotal() {
                let totalHT = 0;
                const selectedMenus = document.querySelectorAll('.menu-checkbox:checked');

                selectedMenus.forEach(menu => {
                    const price = parseFloat(menu.dataset.price);
                    if (!isNaN(price)) {
                        totalHT += price;
                    }
                });

                // Calculate TVA (20%)
                const tva = totalHT * 0.2;
                const totalTTC = totalHT + tva;

                // Update form fields
                totalHTInput.value = totalHT.toFixed(2);
                tvaInput.value = tva.toFixed(2);
                totalTTCInput.value = totalTTC.toFixed(2);
            }

            // Ensure initial calculation is accurate
            calculateTotal();

            // Add event listeners to checkboxes
            menuCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotal);
            });
        });
    </script>
@endsection