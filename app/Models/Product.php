<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'active' => 'boolean',
        ];
    }

    // Relación: Product pertenece a Category (incluso si la categoría está en la papelera)
    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    // Relación: Un producto tiene muchos detalles de venta
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    // Relación: Un producto aparece en muchos detalles de compra[cite: 70]
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}