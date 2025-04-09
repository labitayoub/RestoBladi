@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-orange-100">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <h3 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-receipt text-orange-500 mr-2"></i>Détails de la Vente #{{ $sale->id }}
                    </h3>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600 bg-gray-100 px-3 py-1 rounded-full text-sm">
                        <i class="far fa-calendar-alt mr-1"></i>{{ $sale->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Sale Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <h4 class="text-md font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>Information générale
                    </h4>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Serveur:</span> 
                            @php
                                $waiterId = $sale->waiter_id ?? null;
                                $waiterName = 'N/A';
                                if ($waiterId) {
                                    $waiter = App\Models\Waiter::find($waiterId);
                                    if ($waiter && $waiter->user) {
                                        $waiterName = $waiter->user->name;
                                    }
                                }
                            @endphp
                            {{ $waiterName }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Type de paiement:</span> 
                            @if($sale->payment_type === 'cash')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-money-bill-wave mr-1"></i>Espèce
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-credit-card mr-1"></i>Carte bancaire
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-4 rounded-lg shadow-sm border-l-4 border-amber-500">
                    <h4 class="text-md font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-chair text-amber-500 mr-2"></i>Tables servies
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($sale->tables as $table)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-white text-amber-800 border border-amber-200 shadow-sm">
                                <i class="fas fa-chair mr-2 text-amber-500"></i>{{ $table->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                    <h4 class="text-md font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>Détails de paiement
                    </h4>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Total HT:</span> {{ number_format($sale->total_ttc / 1.2, 2) }} DH
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">TVA (20%):</span> {{ number_format($sale->total_ttc - ($sale->total_ttc / 1.2), 2) }} DH
                        </p>
                        <p class="text-lg font-bold text-green-700">
                            <span class="font-medium">Total TTC:</span> {{ number_format($sale->total_ttc, 2) }} DH
                        </p>
                    </div>
                </div>
            </div>
            
                            <!-- Menus Section -->
            <div class="mb-8">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-utensils text-orange-500 mr-2"></i>Détail des Menus
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sale->menus as $menu)
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="relative">
                                @if(isset($menu->image))
                                <img 
                                    src="{{ asset('images/menus/' . $menu->image) }}" 
                                    alt="{{ $menu->title }}" 
                                    class="w-full h-48 object-cover object-center"
                                    onerror="this.src='{{ asset('images/placeholder-food.jpg') }}'; this.onerror='';"
                                >
                                @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                                </div>
                                @endif
                                
                                @if(isset($menu->price))
                                <div class="absolute top-0 right-0 bg-orange-500 text-white px-3 py-1 rounded-bl-lg font-bold">
                                    {{ number_format($menu->price, 2) }} DH
                                </div>
                                @endif
                            </div>
                            
                            <div class="p-4">
                                <h5 class="text-lg font-bold text-gray-800 mb-2">{{ $menu->title }}</h5>
                                
                                @if(isset($menu->description))
                                    <p class="text-gray-600 text-sm mb-3">{{ $menu->description }}</p>
                                @endif
                                
                                @if(isset($menu->category_id))
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @php
                                        $categoryName = 'Non catégorisé';
                                        $category = App\Models\Category::find($menu->category_id);
                                        if ($category) {
                                            $categoryName = $category->title;
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $categoryName }}
                                    </span>
                                </div>
                                @endif
                                
                                <div class="flex items-center mt-3 text-gray-500 text-xs">
                                    <i class="far fa-calendar-alt mr-1"></i> Créé le: {{ \Carbon\Carbon::parse($menu->created_at)->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex items-center bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>

            </div>
        </div>
    </div>
</div>

<script>
    function printReceipt(id) {
        const printWindow = window.open(`/sales/${id}/receipt`, '_blank');
        printWindow.focus();
    }
</script>
@endsection