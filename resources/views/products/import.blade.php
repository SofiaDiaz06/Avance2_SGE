<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Importar productos desde Excel
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <div class="mb-6 space-y-2 text-sm text-gray-600">
                    <p><strong>Paso 1.</strong> Descargue la plantilla y llénela (una fila por producto).</p>
                    <a href="{{ route('products.template') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Descargar plantilla
                    </a>
                    <p class="mt-4"><strong>Paso 2.</strong> Columnas requeridas: <code>nombre</code>, <code>descripcion</code>, <code>precio</code>, <code>stock</code> y <code>categoria</code> (la categoría debe existir con ese nombre exacto).</p>
                    <p><strong>Paso 3.</strong> Suba el archivo. Si un producto ya existe (mismo nombre), se actualizan precio y categoría; el stock se gestiona por ajustes de inventario.</p>
                </div>

                <form action="{{ route('products.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="file" class="block font-medium text-sm text-gray-700">Archivo Excel o CSV</label>
                        <input type="file" name="file" id="file" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        @error('file')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                            Importar
                        </button>
                        <a href="{{ route('products.index') }}" class="text-sm text-gray-600 underline">Volver a productos</a>
                    </div>
                </form>
            </div>

            <!-- Reporte de errores por fila si los hay -->
            @if (session('failures'))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-red-600 mb-4">Filas omitidas por errores ({{ count(session('failures')) }})</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Fila</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Columna</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Error</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach (session('failures') as $failure)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $failure['fila'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $failure['columna'] }}</td>
                                        <td class="px-6 py-4 text-red-600">{{ implode(' ', $failure['errores']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>