<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    // Etiquetas para mostrar el concepto en pantalla
    public const CONCEPTS = [
        'inventario_inicial' => 'Inventario inicial',
        'compra'             => 'Compra (recepción)',
        'venta'              => 'Venta',
        'anulacion_venta'    => 'Anulación de venta',
        'ajuste'             => 'Ajuste de inventario',
    ];

    protected $fillable = [
        'product_id',
        'type',
        'concept',
        'quantity',
        'balance',
        'unit_cost',
        'reference_type',
        'reference_id',
        'user_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity'  => 'integer',
            'balance'   => 'integer',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Documento que originó el movimiento: Venta, Compra o nada (ajuste/inventario inicial)
    public function reference()
    {
        return $this->morphTo()->withTrashed();
    }

    // Devuelve el texto legible en español del concepto
    public function conceptLabel(): string
    {
        return self::CONCEPTS[$this->concept] ?? $this->concept;
    }

    // Devuelve el número de factura u orden de compra de referencia
    public function referenceLabel(): ?string
    {
        return $this->reference?->invoice_number ?? $this->reference?->purchase_number;
    }
}