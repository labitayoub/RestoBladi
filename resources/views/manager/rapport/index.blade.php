@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Rapports des ventes</h1>
        <p class="text-gray-600">Générez et consultez les rapports de ventes</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4 text-orange-600">Générer un rapport</h2>
        
        <form action="{{ route('reports.generate') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="from" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                    <input type="date" name="from" id="from" required 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                </div>
                
                <div>
                    <label for="to" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                    <input type="date" name="to" id="to" required 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-md transition">
                    <i class="fas fa-search mr-2"></i>Générer le rapport
                </button>
                
                <button type="submit" formaction="{{ route('reports.export') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition">
                    <i class="fas fa-file-excel mr-2"></i>Exporter en Excel
                </button>
            </div>
        </form>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4 text-orange-600">Aperçu des ventes récentes</h2>
        
        @if($dailySales->isEmpty())
            <p class="text-gray-500 italic">Aucune vente enregistrée récemment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-100 font-semibold text-left text-sm text-gray-600">Date</th>
                            <th class="py-2 px-4 bg-gray-100 font-semibold text-right text-sm text-gray-600">Total des ventes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($dailySales as $sale)
                            <tr>
                                <td class="py-3 px-4 text-sm">{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 text-right text-sm">{{ number_format($sale->total, 2) }} Dhs</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="py-3 px-4 font-semibold">Total</td>
                            <td class="py-3 px-4 text-right font-semibold">{{ number_format($dailySales->sum('total'), 2) }} Dhs</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection