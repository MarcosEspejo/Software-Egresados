<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('primer_nombre');
            $table->string('apellidos');
            $table->string('documento_identidad')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('rol')->default('egresado'); // o como prefieras

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
