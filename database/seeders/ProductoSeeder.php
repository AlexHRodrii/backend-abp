<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('producto')->insert([
                [
                    'titulo' => 'Proteina WHEY',
                    'descripcion_producto' => 'Potente proteína de suero de leche en polvo ideal para después del entrenamiento.',
                    'pvp' => 45.50,
                    'stock' => 30,
                    'categoria' => 'Gimnasio',
                ],
                [
                    'titulo' => 'Camiseta negra',
                    'descripcion_producto' => 'Camiseta de corte recto para hombre.',
                    'pvp' => 20.00,
                    'stock' => 50,
                    'categoria' => 'Ropa',
                ],
                [
                    'titulo' => 'Creatina',
                    'descripcion_producto' => 'Aumenta el rendimiento físico en las sucesivas explosiones de ejercicio de alta intensidad de corta duración..',
                    'pvp' => 50.99,
                    'stock' => 20,
                    'categoria' => 'Gimnasio',
                ]
            ]
        );

    }
}
