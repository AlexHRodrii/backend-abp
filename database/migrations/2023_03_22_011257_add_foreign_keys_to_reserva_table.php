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
        Schema::table('reserva', function (Blueprint $table) {
            $table->foreign(['codigo_instalacion'], 'CAJ_RES_INSTALACION')->references(['codigoInstalacion'])->on('instalacion')->onUpdate('CASCADE');
            $table->foreign(['dni'], 'CAJ_RES_USUARIO')->references(['dni'])->on('usuario')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reserva', function (Blueprint $table) {
            $table->dropForeign('CAJ_RES_INSTALACION');
            $table->dropForeign('CAJ_RES_USUARIO');
        });
    }
};
