<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'fecha', /* otras columnas */];

    public function scopeUpcoming($query)
    {
        return $query->where('fecha', '>=', now())->orderBy('fecha', 'asc');
    }
}

