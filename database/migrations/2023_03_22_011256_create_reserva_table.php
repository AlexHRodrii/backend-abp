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
        Schema::create('reserva', function (Blueprint $table) {
            $table->string('dni', 9);
            $table->unsignedBigInteger('codigo_instalacion')->index('CAJ_RES_INSTALACION');
            $table->time('hoa_inicio');
            $table->time('hora_fin');
            $table->date('fecha_reserva');

            $table->primary(['dni', 'codigo_instalacion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserva');
    }
};
