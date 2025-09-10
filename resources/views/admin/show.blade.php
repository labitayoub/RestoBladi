@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col">
                <!-- Header Section -->
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                    <div class="flex items-center">
                        <a href="{{ route('admin.managers') }}" class="text-gray-500 hover:text-gray-700 mr-4 transition duration-150">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <h3 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-user-cog text-orange-500 mr-2"></i>Détails du Manager
                        </h3>
                    </div>
                </div>

                <!-- Manager Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Informations personnelles</h4>
                        <div class="space-y-3">
                            <p class="text-sm text-gray-600 flex">
                                <span class="font-medium w-32">ID:</span>
                                <span>{{ $manager->id }}</span>
                            </p>
                            <p class="text-sm text-gray-600 flex">
                                <span class="font-medium w-32">Nom:</span>
                                <span>{{ $manager->user->name }}</span>
                            </p>
                            <p class="text-sm text-gray-600 flex">
                                <span class="font-medium w-32">Email:</span>
                                <span>{{ $manager->user->email }}</span>
                            </p>
                            <p class="text-sm text-gray-600 flex">
                                <span class="font-medium w-32">Statut:</span>
                                <span>
                                    @if ($manager->status === 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                                    @elseif ($manager->status === 'rejected')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactif</span>
                                    @endif
                                </span>
                            </p>
                            <p class="text-sm text-gray-600 flex">
                                <span class="font-medium w-32">Date d'inscription:</span>
                                <span>{{ $manager->created_at->format('d/m/Y H:i') }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-orange-500">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Informations du restaurant</h4>
                        @if ($manager->restaurant)
                            <div class="space-y-3">
                                <p class="text-sm text-gray-600 flex">
                                    <span class="font-medium w-32">Nom:</span>
                                    <span>{{ $manager->restaurant->name }}</span>
                                </p>
                                <p class="text-sm text-gray-600 flex">
                                    <span class="font-medium w-32">Adresse:</span>
                                    <span>{{ $manager->restaurant->address }}</span>
                                </p>
                                <p class="text-sm text-gray-600 flex">
                                    <span class="font-medium w-32">Téléphone:</span>
                                    <span>{{ $manager->restaurant->phone_number }}</span>
                                </p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Aucune information de restaurant disponible</p>
                        @endif
                    </div>
                </div>

                <!-- Actions pour ce manager -->
                <div class="bg-white p-6 rounded-lg shadow mb-6">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Actions</h4>
                    <div class="flex flex-wrap gap-2">
                        @if ($manager->status === 'rejected')
                            <form action="{{ route('admin.managers.reset', $manager->id) }}" method="post">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    <i class="fas fa-check mr-1"></i>Approuver
                                </button>
                            </form>
                        @elseif ($manager->status === 'approved')
                            <form action="{{ route('admin.managers.reject', $manager->id) }}" method="post">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    <i class="fas fa-times mr-1"></i>Inactif
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Serveurs associés à ce manager -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Serveurs gérés</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nom
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($manager->waiters as $waiter)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $waiter->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $waiter->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $waiter->user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($waiter->status)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Actif
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Aucun serveur associé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection