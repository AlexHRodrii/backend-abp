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
        Schema::table('imagen_producto', function (Blueprint $table) {
            $table->foreign(['referencia_producto'], 'CAJ_PRODUCTO')->references(['codigo_producto'])->on('producto')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imagen_producto', function (Blueprint $table) {
            $table->dropForeign('CAJ_PRODUCTO');
        });
    }
};
