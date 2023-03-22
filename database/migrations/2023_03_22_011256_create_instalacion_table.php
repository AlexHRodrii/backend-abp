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
        Schema::create('instalacion', function (Blueprint $table) {
            $table->bigIncrements('codigo_instalacion')->unique('codigo_instalacion');
            $table->string('nombre_instalacion', 50);
            $table->text('descripcion_instalacion');
            $table->decimal('pvp_por_hora', 15);
            $table->string('deporte_asociado', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instalacion');
    }
};
