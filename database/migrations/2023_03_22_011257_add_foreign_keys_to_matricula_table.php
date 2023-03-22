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
        Schema::table('matricula', function (Blueprint $table) {
            $table->foreign(['codigo_curso'], 'CAJ_MAT_CURSO')->references(['codigo_curso'])->on('curso')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['dni'], 'CAJ_MAT_USUARIO')->references(['dni'])->on('usuario')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matricula', function (Blueprint $table) {
            $table->dropForeign('CAJ_MAT_CURSO');
            $table->dropForeign('CAJ_MAT_USUARIO');
        });
    }
};
