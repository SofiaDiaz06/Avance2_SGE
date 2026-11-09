<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    // Auditoría (Clase 12)
    protected string $auditLog = 'productos';

    // El stock NO se audita aquí: sus cambios quedan en el kardex (inventory_movements)
    protected array $auditExcept = ['stock'];

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

    // Relación: Un producto aparece en muchos detalles de compra
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    // Relación: movimientos del kardex (Clase 12)
    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}