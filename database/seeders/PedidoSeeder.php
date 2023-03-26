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
                    'pvp_total' => 30,
                    'direccion_envio' => 'Calle San Agustín',
                    'fecha' => '2023-05-01',
                    'dni' => '12345678A',
                ],
                [
                    'pvp_total' => 70,
                    'direccion_envio' => 'Calle San Cristóbal',
                    'fecha' => '2023-09-01',
                    'dni' => '12345679B',
                ],
                [
                    'pvp_total' => 8,
                    'direccion_envio' => 'Calle Camino Real',
                    'fecha' => '2023-12-01',
                    'dni' => '45345679L',
                ]
            ]
        );
    }
}
