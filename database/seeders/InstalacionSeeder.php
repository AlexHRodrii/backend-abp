<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstalacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('instalacion')->insert([
                [
                    'nombreInstalacion' => 'Pista de pádel',
                    'descripcionInstalacion' => 'Fantástica pista de pádel para los mejores entrenamientos y partidos',
                    'pvpHora' => 5.50,
                    'deporteAsociado' => 'Pádel',
                ],
                [
                    'nombreInstalacion' => 'Cancha de baloncesto',
                    'descripcionInstalacion' => 'Cancha de baloncesto con canastas reglamentarias y preparadas para las competiciones más exigentes',
                    'pvpHora' => 5.50,
                    'deporteAsociado' => 'Baloncesto',
                ],
                [
                    'nombreInstalacion' => 'Campo de fútbol',
                    'descripcionInstalacion' => 'Campo de fútbol de césped con la mejor calidad y prestaciones para aquellos que disfrutan jugando',
                    'pvpHora' => 10,
                    'deporteAsociado' => 'Fútbol',
                ],
                [
                    'nombreInstalacion' => 'Piscina climatizada',
                    'descripcionInstalacion' => 'Piscina cubierta climatizada con carriles para distintos estilos de nado',
                    'pvpHora' => 6.95,
                    'deporteAsociado' => 'Natación',
                ],
            ]
        );
    }
}
