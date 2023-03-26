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
            $table->bigIncrements('codigoInstalacion')->unique('codigo_instalacion');
            $table->string('nombreInstalacion', 50);
            $table->text('descripcionInstalacion');
            $table->decimal('pvpHora', 15);
            $table->string('deporteAsociado', 30);
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
