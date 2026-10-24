<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8">
                <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del Producto -->
                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700 mb-1">Nombre del Producto</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required autofocus
                               class="w-full rounded-lg border-gray-300 focus:border-[#004e89] focus:ring-[#004e89] shadow-sm">
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="category_id" class="block font-medium text-sm text-gray-700 mb-1">Categoría</label>
                        <select id="category_id" name="category_id" required
                                class="w-full rounded-lg border-gray-300 focus:border-[#004e89] focus:ring-[#004e89] shadow-sm">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Precio -->
                    <div>
                        <label for="price" class="block font-medium text-sm text-gray-700 mb-1">Precio ($)</label>
                        <input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required
                               class="w-full rounded-lg border-gray-300 focus:border-[#004e89] focus:ring-[#004e89] shadow-sm">
                        @error('price')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block font-medium text-sm text-gray-700 mb-1">Stock</label>
                        <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required
                               class="w-full rounded-lg border-gray-300 focus:border-[#004e89] focus:ring-[#004e89] shadow-sm">
                        @error('stock')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo Estado Activo / Inactivo -->
                    <div class="mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="active" value="1" 
                                {{ old('active', $product->active ?? true) ? 'checked' : '' }} 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700 font-medium">Producto activo (disponible para ventas)</span>
                        </label>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold text-sm transition">
                            Cancelar
                        </a>
                        <button type="submit" style="background-color: #004e89; color: #ffffff;" class="px-5 py-2.5 rounded-lg font-semibold text-sm transition shadow-md hover:opacity-90">
                            Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>