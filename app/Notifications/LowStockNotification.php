<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Product $product) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Stock bajo: {$this->product->name}")
            ->greeting("Hola, {$notifiable->name}")
            ->line("El producto «{$this->product->name}» quedó con {$this->product->stock} unidades.")
            ->line('El mínimo configurado es '.config('erp.low_stock_threshold').' unidades.')
            ->action('Crear orden de compra', route('purchases.create'))
            ->line('Este mensaje fue generado automáticamente por el ERP.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Stock bajo',
            'message' => "«{$this->product->name}» quedó con {$this->product->stock} unidades.",
            'url' => route('inventory.kardex', ['product' => $this->product->id]),
        ];
    }
}
