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
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('dni', 9)->primary();
            $table->string('email', 50);
            $table->string('telefono', 15);
            $table->string('nombre', 15);
            $table->string('apellidos', 30);
            $table->date('fecha_nacimiento');
            $table->text('contrasenya');
            $table->text('sal');
            $table->text('imagen_perfil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};
