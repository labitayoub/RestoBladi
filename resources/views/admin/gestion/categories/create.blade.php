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
                    
                    <div class="w-full md:w-2/3 lg:w-3/4">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-xl font-semibold text-gray-700">
                                <i class="fas fa-plus text-orange-500 mr-2"></i>Ajouter une catégorie
                            </h3>
                        </div>
                        
                        <form action="{{ route('categories.store') }}" method="post">
                            @csrf
                            
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre de la catégorie</label>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                                    placeholder="Entrez le titre de la catégorie"
                                    value="{{ old('title') }}"
                                    required
                                >
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    Ajouter la catégorie
                                </button>
                                <a href="{{ route('categories.index') }}" class="ml-4 text-sm text-gray-600 hover:text-gray-900 font-medium">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection