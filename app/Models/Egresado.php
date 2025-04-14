<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{
    use HasFactory;

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'apellidos',
        'documento_identidad',
        'correo_electronico',
        'id_egresado',
        'contrasena',
        'foto_perfil',
        'sexo',
        'nombre_adicional',
        'fecha_nacimiento',
        'nivel_educacion',
        'linkedin',
        'twitter',
        'facebook',
        'instagram',
        'tiktok',
        'github',
        'direccion_postal',
        'direccion',
        'telefono',
        'fax_laboral',
        'empresa',
        'cargo',
        'departamento',
        'carrera',	
    ];

    protected $hidden = [
        'contrasena',
    ];
}
