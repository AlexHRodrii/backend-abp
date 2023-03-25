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
            $table->string('email', 50)->unique();
            $table->string('telefono', 12)->nullable();
            $table->string('nombre', 15);
            $table->string('apellidos', 30);
            $table->date('fechaNacimiento');
            $table->text('password');
            $table->text('imagenPerfil')->nullable();
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
