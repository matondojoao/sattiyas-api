<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $pdfPath;
    protected $order;

    public function __construct($pdfPath, $order)
    {
        $this->pdfPath = $pdfPath;
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pedido Realizado')
            ->line('Obrigado por fazer um pedido!')
            ->action('Detalhes do Pedido', config('app.url_frontend').('/orders/' . $this->order->id))
            ->attachData(file_get_contents($this->pdfPath), 'order_' . $this->order->id . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->line('O PDF do seu pedido está anexado a este e-mail.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
