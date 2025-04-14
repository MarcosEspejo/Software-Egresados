<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // DATOS PERSONALES
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('apellidos');
            $table->string('documento_identidad')->unique();
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->string('password');
            $table->string('rol')->default('egresado'); // egresado, jefe, admin

            // SOLO PARA EGRESADOS
            $table->string('sexo')->nullable();
            $table->string('nombre_adicional')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('nivel_educacion')->nullable();
            $table->string('carrera')->nullable();

            // REDES SOCIALES
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('github')->nullable();

            // CONTACTO
            $table->string('direccion_postal')->nullable();
            $table->string('fax_laboral')->nullable();

            // INFORMACIÓN LABORAL
            $table->string('empresa')->nullable();
            $table->string('cargo')->nullable();
            $table->string('departamento')->nullable();

            // JETSTREAM / FORTIFY
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
