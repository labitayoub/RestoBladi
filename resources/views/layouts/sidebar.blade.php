<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="p-4 bg-orange-50 border-b border-orange-100">
        <h3 class="text-lg font-semibold text-orange-600">
            <i class="fas fa-utensils mr-2"></i>Management
        </h3>
    </div>

    <nav class="mt-2">
        <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150 ease-in-out border-l-4 border-transparent hover:border-orange-400">
            <i class="fas fa-th-list w-6 text-orange-500"></i>
            <span class="ml-2 font-medium">Catégories</span>
        </a>
        
        <a href="{{ route('menus.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150 ease-in-out border-l-4 border-transparent hover:border-orange-400">
            <i class="fas fa-clipboard-list w-6 text-orange-500"></i>
            <span class="ml-2 font-medium">Menus</span>
        </a>
        
        <a href="{{ route('tables.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150 ease-in-out border-l-4 border-transparent hover:border-orange-400">
            <i class="fas fa-chair w-6 text-orange-500"></i>
            <span class="ml-2 font-medium">Tables</span>
        </a>
        
        <a href="{{ route('waiters.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150 ease-in-out border-l-4 border-transparent hover:border-orange-400">
            <i class="fas fa-user-cog w-6 text-orange-500"></i>
            <span class="ml-2 font-medium">Sérveurs</span>
        </a>
    </nav>
</div>