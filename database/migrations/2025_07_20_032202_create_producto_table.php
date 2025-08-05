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
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad')->default(0);
            $table->foreignId('id_categoria')->references('id')->on('categoria');
            $table->foreignId('id_subcategoria')->references('id')->on('sub_categoria');
            $table->string('codigo_barras', 50)->unique()->nullable(); // Código
            $table->string('estado', 20); // Estado del producto .
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
