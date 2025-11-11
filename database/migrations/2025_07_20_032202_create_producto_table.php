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
            $table->decimal('precio_oferta', 10, 2)->nullable();
            $table->string('oferta_tipo', 50)->nullable();
            $table->decimal('precio_oferta_tipo', 10, 2)->nullable();
            $table->integer('cantidad')->default(0);
            $table->foreignId('id_categoria')->constrained('categoria')->onDelete('cascade');
            $table->foreignId('id_subcategoria')->nullable()->constrained('sub_categoria')->onDelete('cascade');
            $table->string('codigo_barras', 50)->unique()->nullable();
            $table->string('estado', 20);
            $table->foreignId('id_empresa')->constrained('empresa')->onDelete('cascade');
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
