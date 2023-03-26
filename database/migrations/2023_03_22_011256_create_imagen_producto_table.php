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
        Schema::create('imagenProducto', function (Blueprint $table) {
            $table->bigIncrements('codigoImagen')->unique('codigoImagen');
            $table->text('url');
            $table->unsignedBigInteger('referenciaProducto')->index('CAJ_PRODUCTO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagenProducto');
    }
};
