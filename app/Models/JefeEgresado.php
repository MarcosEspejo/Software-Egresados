<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class JefeEgresado extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'documento',
        'email',
        'telefono',
        'direccion',
        'password',
        'foto_perfil',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
