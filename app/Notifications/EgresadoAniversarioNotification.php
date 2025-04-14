<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class EgresadoAniversarioNotification extends Notification
{
    use Queueable;

    protected $egresado;

    public function __construct($egresado)
    {
        $this->egresado = $egresado;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Actualiza tu Información')
            ->line('¡Felicidades! Ha pasado un año desde que te registraste.')
            ->line('Por favor, actualiza tu información haciendo clic en el siguiente enlace:')
            ->action('Actualizar Información', url('/egresados/' . $this->egresado->id . '/edit'))
            ->line('Gracias por ser parte de nuestra comunidad!');
    }
}