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
            $table->unsignedBigInteger('codigoInstalacion')->index('CAJ_RES_INSTALACION');
            $table->time('hoaInicio');
            $table->time('horaFin');
            $table->date('fechaReserva');

            $table->primary(['dni', 'codigoInstalacion']);
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
