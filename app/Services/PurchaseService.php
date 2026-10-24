<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseService
{
    public function register(array $data, int $userId): Purchase
    {
        return DB::transaction(function () use ($data, $userId) {
            $items = [];
            $subtotal = 0;

            foreach ($data['items'] as $item) {
                $quantity = (int) $item['quantity'];
                $unitCost = round((float) $item['unit_cost'], 2);
                $lineSubtotal = round($quantity * $unitCost, 2);

                $items[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'subtotal' => $lineSubtotal,
                ];

                $subtotal += $lineSubtotal;
            }

            $tax = round($subtotal * 0.19, 2);
            $total = round($subtotal + $tax, 2);

            $purchase = Purchase::create([
                'purchase_number' => $this->nextPurchaseNumber(),
                'provider_id' => $data['provider_id'],
                'user_id' => $userId,
                'purchase_date' => $data['purchase_date'],
                'provider_invoice' => $data['provider_invoice'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pendiente',
                'notes' => $data['notes'] ?? null,
            ]);

            $purchase->details()->createMany($items);

            return $purchase;
        });
    }

    public function receive(Purchase $purchase, array $quantities, ?string $providerInvoice = null): Purchase
    {
        return DB::transaction(function () use ($purchase, $quantities, $providerInvoice) {
            $purchase = Purchase::lockForUpdate()->findOrFail($purchase->id);
            $purchase->load('details.product');

            if (!$purchase->canBeReceived()) {
                throw ValidationException::withMessages([
                    'items' => "La orden {$purchase->purchase_number} está «{$purchase->status}» y no admite recepciones.",
                ]);
            }

            $unknown = array_diff(array_keys($quantities), $purchase->details->pluck('id')->all());
            if (!empty($unknown)) {
                throw ValidationException::withMessages([
                    'items' => 'Se enviaron líneas que no pertenecen a esta orden de compra.',
                ]);
            }

            $receivedSomething = false;

            foreach ($purchase->details as $detail) {
                $quantity = (int) ($quantities[$detail->id] ?? 0);
                if ($quantity === 0) {
                    continue;
                }

                if ($quantity > $detail->pendingQuantity()) {
                    throw ValidationException::withMessages([
                        'items' => "No se puede recibir más de lo pedido para «{$detail->product?->name}». Pendiente: {$detail->pendingQuantity()}, recibido ahora: {$quantity}.",
                    ]);
                }

                $detail->increment('received_quantity', $quantity);

                Product::withTrashed()
                    ->lockForUpdate()
                    ->findOrFail($detail->product_id)
                    ->increment('stock', $quantity);

                $receivedSomething = true;
            }

            if (!$receivedSomething) {
                throw ValidationException::withMessages([
                    'items' => 'Debe ingresar al menos una cantidad mayor que cero para registrar la recepción.',
                ]);
            }

            $purchase->load('details');
            $complete = $purchase->details->every(fn ($d) => $d->received_quantity >= $d->quantity);

            $purchase->update([
                'status' => $complete ? 'recibida' : 'parcial',
                'received_at' => $complete ? now() : null,
                'provider_invoice' => $providerInvoice ?: $purchase->provider_invoice,
            ]);

            return $purchase;
        });
    }

    public function cancel(Purchase $purchase): void
    {
        if (!$purchase->canBeCancelled()) {
            throw ValidationException::withMessages([
                'purchase' => "La orden {$purchase->purchase_number} ya tiene mercancía recibida y no se puede anular.",
            ]);
        }

        DB::transaction(function () use ($purchase) {
            $purchase->update(['status' => 'anulada']);
            $purchase->delete();
        });
    }

    private function nextPurchaseNumber(): string
    {
        $last = Purchase::withTrashed()->orderByDesc('id')->first();
        $next = $last ? $last->id + 1 : 1;

        return 'OC-'.str_pad($next, 5, '0', STR_PAD_LEFT);
    }
}