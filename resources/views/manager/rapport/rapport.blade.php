@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Rapport de ventes</h1>
            <p class="text-gray-600">Période: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        </div>
        
        <form action="{{ route('reports.export') }}" method="POST">
            @csrf
            <input type="hidden" name="from" value="{{ $startDate }}">
            <input type="hidden" name="to" value="{{ $endDate }}">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition">
                <i class="fas fa-file-excel mr-2"></i>Exporter en Excel
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-orange-600">Résumé</h2>
            <p class="text-xl font-bold text-green-600">Total: {{ number_format($total, 2) }} Dhs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                <p class="text-gray-500 text-sm">Nombre de ventes</p>
                <p class="text-xl font-semibold">{{ $sales->count() }}</p>
            </div>
            
            <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                <p class="text-gray-500 text-sm">Moyenne par vente</p>
                <p class="text-xl font-semibold">
                    {{ $sales->count() > 0 ? number_format($total / $sales->count(), 2) : '0.00' }} Dhs
                </p>
            </div>
            
            <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                <p class="text-gray-500 text-sm">Première vente</p>
                <p class="text-xl font-semibold">
                    {{ $sales->min('created_at') ? \Carbon\Carbon::parse($sales->min('created_at'))->format('d/m/Y') : 'N/A' }}
                </p>
            </div>
            
            <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                <p class="text-gray-500 text-sm">Dernière vente</p>
                <p class="text-xl font-semibold">
                    {{ $sales->max('created_at') ? \Carbon\Carbon::parse($sales->max('created_at'))->format('d/m/Y') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4 text-orange-600">Détail des ventes</h2>
        
        @if($sales->isEmpty())
            <p class="text-gray-500 italic">Aucune vente trouvée pour cette période.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm leading-normal">
                            <th class="py-3 px-4 text-left">N° Vente</th>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Serveur</th>
                            <th class="py-3 px-4 text-left">Table</th>
                            <th class="py-3 px-4 text-left">Articles</th>
                            <th class="py-3 px-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($sales as $sale)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $sale->id }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4">
                                    @if($sale->waiter && $sale->waiter->user)
                                        {{ $sale->waiter->user->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($sale->tables)
                                        @foreach($sale->tables as $table)
                                            {{ $table->name }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-xs text-white bg-orange-500 rounded-full px-2 py-1">
                                        {{ $sale->menus ? $sale->menus->count() : 0 }} articles
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right font-medium">{{ number_format($sale->total_ttc, 2) }} Dhs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    
    <div class="mt-6">
        <div class="flex space-x-4">
            <a href="{{ route('reports.index') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux rapports
            </a>
            <a href="{{ route('dashboard') }}" class="bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                <i class="fas fa-tachometer-alt mr-2"></i>Retour au tableau de bord
            </a>
        </div>
    </div>
</div>
@endsection
