<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JefeEgresado;
use Illuminate\Support\Facades\Hash;

class JefeEgresadoSeeder extends Seeder
{
    public function run()
    {
        JefeEgresado::create([
            'nombre' => 'Jefe de Egresados',
            'email' => 'jefe@libertadores.edu.co',
            'password' => Hash::make('password123'),
        ]);
    }
}
