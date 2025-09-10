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
                                <i class="fas fa-plus text-orange-500 mr-2"></i>Ajouter un menu
                            </h3>
                        </div>
                        
                        <form action="{{ route('menus.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre du menu</label>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('title') border-red-500 @enderror"
                                    placeholder="Entrez le titre du menu"
                                    value="{{ old('title') }}"
                                    
                                >
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="5"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror"
                                    placeholder="Entrez la description du menu"
                                    
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Prix (DH)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">DH</span>
                                    </div>
                                    <input
                                        type="number"
                                        name="price"
                                        id="price"
                                        step="0.01"
                                        class="w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('price') border-red-500 @enderror"
                                        placeholder="0.00"
                                        value="{{ old('price') }}"
                                        
                                    >
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                    </div>
                                </div>
                                @error('price')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                                <div class="mt-1 flex items-center space-x-5">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none">
                                        <span class="py-2 px-4 border border-gray-300 rounded-md shadow-sm">Choisir une image</span>
                                        <input 
                                            type="file" 
                                            name="image" 
                                            id="image"
                                            class="sr-only @error('image') border-red-500 @enderror"
                                            
                                        >
                                    </label>
                                    <span class="text-sm text-gray-500" id="file-name">Aucun fichier sélectionné (2MB max)</span>
                                </div>
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                                <select
                                    name="category_id"
                                    id="category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 @error('category_id') border-red-500 @enderror"
                                    
                                >
                                    <option value="" selected disabled>Choisir une catégorie</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    Ajouter le menu
                                </button>
                                <a href="{{ route('menus.index') }}" class="ml-4 text-sm text-gray-600 hover:text-gray-900 font-medium">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Afficher le nom du fichier sélectionné
        document.getElementById('image').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || 'Aucun fichier sélectionné (2MB max)';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
@endsection