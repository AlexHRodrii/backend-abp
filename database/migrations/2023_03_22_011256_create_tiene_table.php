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
            $table->unsignedBigInteger('numeroPedido')->unique('numeroPedido');
            $table->unsignedBigInteger('codigoProducto')->index('CAJ_TIENE_PRODUCTO');

            $table->primary(['numeroPedido', 'codigoProducto']);
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
