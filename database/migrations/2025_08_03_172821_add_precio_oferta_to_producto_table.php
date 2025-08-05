<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrecioOfertaToProductoTable extends Migration
{
    public function up()
    {
        Schema::table('producto', function (Blueprint $table) {
            $table->decimal('precio_oferta', 10, 2)->nullable()->after('precio');
        });
    }

    public function down()
    {
        Schema::table('producto', function (Blueprint $table) {
            $table->dropColumn('precio_oferta');
        });
    }
}
