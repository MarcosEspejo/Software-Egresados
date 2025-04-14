<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Egresado;
use App\Notifications\EgresadoAniversarioNotification;
use Illuminate\Support\Facades\Notification;

class EnviarNotificacionesEgresados extends Command
{
    protected $signature = 'egresados:enviar-notificaciones';
    protected $description = 'Enviar notificaciones a egresados que cumplen un año desde su registro';

    public function handle()
    {
        $egresados = Egresado::where('created_at', '<=', now()->subYear())->get();

        foreach ($egresados as $egresado) {
            $egresado->notify(new EgresadoAniversarioNotification($egresado));
        }

        $this->info('Notificaciones enviadas a los egresados que cumplen un año.');
    }
}