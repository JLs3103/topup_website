<?php

namespace App\Notifications;

use App\Models\TopupOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly TopupOrder $order,
        private readonly string $oldStatus,
        private readonly string $newStatus,
        private readonly ?string $adminNote = null,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusLabel = strtoupper($this->newStatus);

        return [
            'title' => 'Status transaksi diperbarui',
            'message' => 'Transaksi '.$this->order->order_code.' sekarang berstatus '.$statusLabel.'.',
            'order_id' => $this->order->id,
            'order_code' => $this->order->order_code,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'admin_note' => $this->adminNote,
            'updated_at' => now()->toDateTimeString(),
        ];
    }
}
