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
        Schema::create('imagen_producto', function (Blueprint $table) {
            $table->bigIncrements('codigo_imagen')->unique('codigo_imagen');
            $table->text('url');
            $table->unsignedBigInteger('referencia_producto')->index('CAJ_PRODUCTO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagen_producto');
    }
};
