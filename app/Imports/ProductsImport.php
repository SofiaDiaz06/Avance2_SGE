<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements SkipsOnFailure, ToCollection, WithHeadingRow, WithValidation
{
    use SkipsFailures;

    public int $created = 0;
    public int $updated = 0;

    public function __construct(private InventoryService $inventory) {}

    // <-- AQUÍ ESTÁ LA CORRECCIÓN: Se añade ": void" al final de la función
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $category = Category::where('name', trim((string) $row['categoria']))->first();

            $product = Product::where('name', trim((string) $row['nombre']))->first();

            if ($product) {
                $product->update([
                    'price' => $row['precio'],
                    'category_id' => $category->id,
                ]);
                $this->updated++;

                continue;
            }

            $product = Product::create([
                'name' => trim((string) $row['nombre']),
                'price' => $row['precio'],
                'stock' => (int) ($row['stock'] ?? 0),
                'category_id' => $category->id,
                'active' => true,
            ]);

            // El stock del archivo entra al kardex como «inventario inicial»
            $this->inventory->opening($product);
            $this->created++;
        }
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'categoria' => ['required', Rule::exists('categories', 'name')->whereNull('deleted_at')],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'categoria.required' => 'La categoría es obligatoria.',
            'categoria.exists' => 'La categoría «:input» no existe. Créela primero o corrija el nombre.',
        ];
    }
}