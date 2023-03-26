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
        Schema::table('imagenCurso', function (Blueprint $table) {
            $table->foreign(['referenciaCurso'], 'CAJ_CURSO')->references(['codigoCurso'])->on('curso')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imagenCurso', function (Blueprint $table) {
            $table->dropForeign('CAJ_CURSO');
        });
    }
};
