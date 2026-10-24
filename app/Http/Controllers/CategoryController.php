<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:ver-categorias', only: ['index']),
            new Middleware('permission:crear-categorias', only: ['create', 'store']),
            new Middleware('permission:editar-categorias', only: ['edit', 'update']),
            new Middleware('permission:eliminar-categorias', only: ['destroy', 'restore', 'trash']),
        ];
    }

    public function index(Request $request)
    {
        $showTrashed = $request->boolean('trashed') && $request->user()->can('eliminar-categorias');

        $categories = Category::query()
            ->withCount('products')
            ->when($showTrashed, fn ($query) => $query->onlyTrashed())
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('active', $request->input('status') === 'active'))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', [
            'categories' => $categories,
            'showTrashed' => $showTrashed,
            'trashedCount' => Category::onlyTrashed()->count(),
        ]);
    }

    public function create()
    {
        return view('categories.create', [
            'category' => new Category(['active' => true]),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['active'] = $request->has('active');

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $validated['active'] = $request->has('active');

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', "No se puede eliminar «{$category->name}»: tiene productos asociados.");
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', "Categoría «{$category->name}» enviada a la papelera.");
    }

    /**
     * Muestra el listado de categorías en la papelera.
     */
    public function trash()
    {
        $categories = Category::onlyTrashed()->orderBy('name')->paginate(10);
        return view('categories.trash', compact('categories'));
    }

    /**
     * Restaura una categoría eliminada.
     */
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.index')
            ->with('success', "Categoría «{$category->name}» restaurada exitosamente.");
    }
}