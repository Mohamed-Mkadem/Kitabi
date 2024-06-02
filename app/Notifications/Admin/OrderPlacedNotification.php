<?php

namespace App\Notifications\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\support\Facades\NotificationUrlBuilder;

class OrderPlacedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Order $order, protected  User $client)
    {
        $this->order = $order;
        $this->client = $client;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
            'mail',
            'broadcast'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = NotificationUrlBuilder::generateUrl($this->id, 'admin.orders.show', $this->order->id);
        return (new MailMessage)
            ->subject('طلب جديد')
            ->greeting("مرحبا {$notifiable->fullName}")
            ->line("قام {$this->client->fullName} بإنشاء طلب جديد")
            ->line("(د.ت) قيمة الطلب : {$this->order->formattedAmount}")
            ->line("رقم الطلب : #{$this->order->id}")
            ->action('معالجة الطلب', $url)
            ->line('مؤسسة كتابي');
    }

    public function toDatabase(object $notifiable)
    {
        $url = NotificationUrlBuilder::generateUrl($this->id, 'admin.orders.show', $this->order->id);
        return [
            'image'   => $this->client->photo,
            'body' => "قام {$this->client->fullName} بإنشاء طلب جديد",
            'url' => $url,
            'created_at' => time()
        ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toBroadcast(object $notifiable): array
    {
        $url = NotificationUrlBuilder::generateUrl($this->id, 'admin.orders.show', $this->order->id);
        return [
            'image' => asset('storage/' . $this->client->photo),
            'body' => "طلب جديد : قام {$this->client->fullName} بإنشاء طلب جديد بقيمة {$this->order->formattedAmount} د.ت ",
            'url' => $url,
            'created_at' => time(),
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
