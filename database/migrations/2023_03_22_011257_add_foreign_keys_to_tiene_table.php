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
        Schema::table('tiene', function (Blueprint $table) {
            $table->foreign(['numeroPedido'], 'CAJ_TIENE_PEDIDO')->references(['numeroPedido'])->on('pedido')->onUpdate('CASCADE');
            $table->foreign(['codigoProducto'], 'CAJ_TIENE_PRODUCTO')->references(['codigoProducto'])->on('producto')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiene', function (Blueprint $table) {
            $table->dropForeign('CAJ_TIENE_PEDIDO');
            $table->dropForeign('CAJ_TIENE_PRODUCTO');
        });
    }
};
