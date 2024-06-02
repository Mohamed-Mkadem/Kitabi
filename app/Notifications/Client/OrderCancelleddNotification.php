<?php

namespace App\Notifications\Client;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\NotificationUrlBuilder;

class OrderCancelleddNotification extends Notification
{
    use Queueable;

    protected $admin;
    /**
     * Create a new notification instance.
     */
    public function __construct(protected $order)
    {
        $this->admin = User::where('role', 'admin')->first();
        $this->order->order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }


    public function toDatabase(object $notifiable): array
    {
        $url = NotificationUrlBuilder::generateUrl($this->id, 'client.orders.show', $this->order->id);
        return [
            'image'   =>  $this->admin->photo,
            'body' => "للأسف تمّ إلغاء الطلب رقم #{$this->order->id}",
            'url' => $url,
            'created_at' => time()
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        $url = NotificationUrlBuilder::generateUrl($this->id, 'client.orders.show', $this->order->id);
        return [
            'image'   => asset('storage/' . $this->admin->photo),
            'body' =>  "للأسف تمّ إلغاء الطلب رقم #{$this->order->id}",
            'url' => $url,
            'created_at' => time()
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
