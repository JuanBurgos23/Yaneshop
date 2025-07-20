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
        Schema::create('imagen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto'); // Cambiado a 'producto_id' para mantener consistencia
            $table->string('ruta'); // o 'url' si prefieres
            $table->timestamps();

            $table->foreign('id_producto')->references('id')->on('producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagen');
    }
};
