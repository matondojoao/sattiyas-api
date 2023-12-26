<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNewsletterSubscription extends Notification implements ShouldQueue
{
    use Queueable;

    private $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
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
        $url = config('app.url_frontend') .'/shop';
        return (new MailMessage)
            ->subject('Bem-vindo à essence!')
            ->line('Olá!')
            ->line('Obrigado por subscrever a nossa newsletter.')
            ->line('Agora você está conectado com as últimas tendências, promoções exclusivas e novidades emocionantes.')
            ->line('Continue explorando as últimas coleções em nosso site.')
            ->action('Explore Agora', $url)
            ->line('Email da nova assinatura: ' . $this->email)
            ->salutation('Moda é uma expressão de quem você é - seja única, seja você!')
            ->line('Obrigado por escolher a nossa newsletter de moda!');
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
