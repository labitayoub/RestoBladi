@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-4 mb-6">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-user-cog text-orange-500 mr-2"></i>Gestion des Managers
                        </h3>
                    </div>
                </div>
                
                <!-- Notification Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                
                <!-- Managers Table -->
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
                                    Restaurant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($managers as $manager)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $manager->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $manager->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $manager->user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $manager->restaurant->name ?? 'Non défini' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($manager->status === 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        @elseif ($manager->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @elseif ($manager->status === 'rejected')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejeté
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if ($manager->status === 'rejected')
                                                <form action="{{ route('admin.managers.reset', $manager->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-md text-sm transition duration-150 ease-in-out" title="Approuver">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @elseif ($manager->status === 'approved')
                                                <form action="{{ route('admin.managers.reject', $manager->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm transition duration-150 ease-in-out" title="Rejeter">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @elseif ($manager->status === 'pending')
                                                <form action="{{ route('admin.managers.approve', $manager->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-md text-sm transition duration-150 ease-in-out" title="Approuver">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Vue détaillée -->
                                            <a href="{{ route('admin.managers.show', $manager->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md text-sm transition duration-150 ease-in-out">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Aucun manager trouvé
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
@endsection