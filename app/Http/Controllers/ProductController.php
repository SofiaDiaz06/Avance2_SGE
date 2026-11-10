<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:ver-productos', only: ['index']),
            new Middleware('permission:crear-productos', only: ['create', 'store']),
            new Middleware('permission:editar-productos', only: ['edit', 'update']),
            new Middleware('permission:eliminar-productos', only: ['destroy', 'restore', 'trash']),
        ];
    }

    public function index(Request $request): View
    {
        $showTrashed = $request->boolean('trashed') && $request->user()->can('eliminar-productos');

        $products = Product::query()
            ->with('category')
            ->when($showTrashed, fn ($query) => $query->onlyTrashed())
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->string('search')->value().'%');
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->filled('status'), fn ($query) => $query->where('active', $request->input('status') === 'active'))
            ->latest($showTrashed ? 'deleted_at' : 'created_at')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'showTrashed' => $showTrashed,
            'trashedCount' => Product::onlyTrashed()->count(),
        ]);
    }

    public function create(): View
    {
        return view('products.create', [
            'product' => new Product(['active' => true, 'stock' => 0]),
            'categories' => $this->selectableCategories(),
        ]);
    }

    public function store(StoreProductRequest $request, InventoryService $inventory): RedirectResponse
    {
        $product = Product::create($request->validated());
        $inventory->opening($product);

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Product $product): View
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => $this->selectableCategories(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Producto «{$product->name}» enviado a la papelera.");
    }

    public function trash(): View
    {
        $products = Product::onlyTrashed()->orderBy('name')->paginate(10);
        return view('products.trash', compact('products'));
    }

    public function restore(Product $product): RedirectResponse
    {
        if ($product->category?->trashed()) {
            return back()->with('error', "Restaura primero la categoría «{$product->category->name}».");
        }

        $product->restore();

        return redirect()->route('products.index', ['trashed' => 1])
            ->with('success', "Producto «{$product->name}» restaurado.");
    }

    private function selectableCategories(): Collection
    {
        return Category::where('active', true)->orderBy('name')->get(['id', 'name']);
    }
}