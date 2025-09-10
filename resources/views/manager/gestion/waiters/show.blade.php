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
                
                <div class="w-full md:w-2/3 lg:w-3/4">
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-xl font-semibold text-gray-700">
                            <i class="fas fa-user text-orange-500 mr-2"></i>Détails du Serveur
                        </h3>
                        <a href="{{ route('waiters.index') }}" class="text-orange-500 hover:text-orange-700 font-medium">
                            <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
                        </a>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Informations de l'utilisateur</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">ID</p>
                                <p class="mt-1 text-base text-gray-900">{{ $waiter->id }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nom</p>
                                <p class="mt-1 text-base text-gray-900">{{ $waiter->user->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1 text-base text-gray-900">{{ $waiter->user->email ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Numéro de téléphone</p>
                                <p class="mt-1 text-base text-gray-900">{{ $waiter->phone_number }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Statut</p>
                                <p class="mt-1">
                                    @if ($waiter->status == 1)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Inactif
                                        </span>
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date de création</p>
                                <p class="mt-1 text-base text-gray-900">{{ $waiter->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Information Section -->
                    <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200 mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Information sur le mot de passe</h4>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-600"><i class="fas fa-lock text-yellow-600 mr-2"></i> Pour des raisons de sécurité, les mots de passe sont cryptés et ne peuvent pas être affichés en texte clair.</p>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">Dernière mise à jour du mot de passe:</p>
                            <p class="mt-1 text-base text-gray-900">
                                @if($waiter->user && $waiter->user->updated_at)
                                    {{ $waiter->user->updated_at->format('d/m/Y H:i') }}
                                @else
                                    Non disponible
                                @endif
                            </p>
                        </div>
                        
                        <a href="{{ route('waiters.edit', $waiter->id) }}#password" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-key mr-2"></i> Réinitialiser le mot de passe
                        </a>
                    </div>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('waiters.edit', $waiter->id) }}" class="bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            <i class="fas fa-edit mr-1"></i> Modifier
                        </a>
                        <form action="{{ route('waiters.destroy', $waiter->id) }}" method="post">
                            @csrf
                            @method("DELETE")
                            <button
                                type="submit"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce serveur?')"
                                class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                <i class="fas fa-trash mr-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
