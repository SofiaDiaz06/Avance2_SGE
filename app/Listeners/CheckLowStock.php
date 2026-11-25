<?php

namespace App\Listeners;

use App\Events\SaleRegistered;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;

class CheckLowStock
{
    public function handle(SaleRegistered $event): void
    {
        $threshold = config('erp.low_stock_threshold');
        $event->sale->loadMissing('details.product');

        foreach ($event->sale->details as $detail) {
            $product = $detail->product?->fresh();
            if (! $product) {
                continue;
            }

            $before = $product->stock + $detail->quantity;

            // Solo se alerta cuando el producto CRUZA el umbral hacia abajo
            if ($before > $threshold && $product->stock <= $threshold) {
                Notification::send($this->recipients(), new LowStockNotification($product));
            }
        }
    }

    private function recipients()
    {
        return User::permission('crear-compras')->where('active', true)->get();
    }
}
