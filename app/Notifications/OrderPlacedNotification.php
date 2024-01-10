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
            ->subject('Pedido Realizado - #' . $this->order->id)
            ->greeting('Olá, ' . $this->order->user->name . '!')
            ->line('Obrigado por fazer um pedido conosco. Confirmamos o recebimento do seu pedido com os seguintes detalhes:')
            ->line('Número do Pedido: #' . $this->order->id)
            ->line('Data do Pedido: ' . \Carbon\Carbon::parse($this->order->created_at)->format('d/m/Y H:i:s'))
            ->line('Detalhes do Pedido: ' . config('app.url_frontend') . '/meu-pedido/' . $this->order->id)
            ->attachData(file_get_contents($this->pdfPath), 'order_' . $this->order->id . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->line('Você pode visualizar e fazer o download do PDF do seu pedido, que está anexado a este e-mail.')
            ->action('Acompanhe seu Pedido', config('app.url_frontend') . '/meu-pedido/' . $this->order->id);
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
