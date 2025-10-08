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
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->nullable();
            $table->string('nombre');
            $table->string('telefono_whatsapp')->nullable();
            $table->string('logo')->nullable();
            $table->string('direccion')->nullable();
            $table->string('slug',255)->nullable();
            $table->dateTime('fecha_inicio_suscripcion')->nullable();
            $table->dateTime('fecha_fin_suscripcion')->nullable();
            $table->string('tipo_suscripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
