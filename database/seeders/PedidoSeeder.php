<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pedido')->insert([
                [
                    'pvpTotal' => 30,
                    'direccionEnvio' => 'Calle San Agustín',
                    'fecha' => '2023-05-01',
                    'dni' => '00000000A',
                ],
                [
                    'pvpTotal' => 70,
                    'direccionEnvio' => 'Calle San Cristóbal',
                    'fecha' => '2023-09-01',
                    'dni' => '00000000B',
                ],
                [
                    'pvpTotal' => 8,
                    'direccionEnvio' => 'Calle Camino Real',
                    'fecha' => '2023-12-01',
                    'dni' => '00000000A',
                ]
            ]
        );
    }
}
