<?php

namespace App\Listeners;

use App\Events\SaleCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Module;

class UpdateInventoryOnSale
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SaleCompleted $event): void
    {
        // Condición clave: Si el módulo de productos está inactivo, omite el descuento de stock de forma elegante
        if (!Module::isActive('products')) {
            return;
        }

        $sale = $event->sale;

        // Aquí colocas la lógica para recorrer los productos de la venta y descontar el stock
        // Ejemplo genérico:
        foreach ($sale->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->stock -= $item->quantity;
                $product->save();
            }
        }
    }
}