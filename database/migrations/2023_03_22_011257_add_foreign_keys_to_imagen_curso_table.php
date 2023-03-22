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
        Schema::table('imagen_curso', function (Blueprint $table) {
            $table->foreign(['referencia_curso'], 'CAJ_CURSO')->references(['codigo_curso'])->on('curso')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imagen_curso', function (Blueprint $table) {
            $table->dropForeign('CAJ_CURSO');
        });
    }
};
