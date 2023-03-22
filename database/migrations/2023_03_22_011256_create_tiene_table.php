<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiene', function (Blueprint $table) {
            $table->unsignedBigInteger('numero_pedido')->unique('numero_pedido');
            $table->unsignedBigInteger('codigo_producto')->index('CAJ_TIENE_PRODUCTO');

            $table->primary(['numero_pedido', 'codigo_producto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiene');
    }
};
