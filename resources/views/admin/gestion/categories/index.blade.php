@extends('layouts.app')

@section("content")
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <!-- Sidebar -->
                    <div class="w-full md:w-1/3 lg:w-1/4 mb-6 md:mb-0 md:pr-6">
                        @include('layouts.sidebar')
                    </div>
                    
                    <!-- Main Content -->
                    <div class="w-full md:w-2/3 lg:w-3/4">
                        <div class="flex flex-row justify-between items-center border-b border-gray-200 pb-4 mb-4">
                            <h3 class="text-xl font-semibold text-gray-700">
                                <i class="fas fa-th-list text-orange-500 mr-2"></i>Catégories
                            </h3>
                            <a href="{{ route('categories.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                <i class="fas fa-plus mr-1"></i>Ajouter
                            </a>
                        </div>
                        
                        <!-- Categories Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Id
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Titre
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($categories as $category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $category->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $category->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('categories.edit', $category->slug) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-md text-sm transition duration-150 ease-in-out">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form id="{{ $category->id }}" action="{{ route('categories.destroy', $category->slug) }}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button
                                                            onclick="
                                                                event.preventDefault();
                                                                if(confirm('Voulez vous supprimer la catégorie {{ $category->title }} ?'))
                                                                document.getElementById({{ $category->id }}).submit()
                                                            "
                                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm transition duration-150 ease-in-out">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination (if needed) -->
                        @if(isset($categories) && method_exists($categories, 'links'))
                            <div class="mt-4">
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection