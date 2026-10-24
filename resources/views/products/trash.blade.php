<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Papelera de Productos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6 space-y-4">
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('products.index') }}" class="underline">← Volver a productos</a>
                </div>

                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="p-2">ID</th>
                            <th class="p-2">Nombre</th>
                            <th class="p-2">Eliminado el</th>
                            <th class="p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-b">
                                <td class="p-2">{{ $product->id }}</td>
                                <td class="p-2">{{ $product->name }}</td>
                                <td class="p-2">{{ $product->deleted_at }}</td>
                                <td class="p-2">
                                    <form method="POST" action="{{ route('products.restore', $product->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-700 underline">Restaurar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">La papelera de productos está vacía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>