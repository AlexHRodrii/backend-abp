<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('curso')->insert([
                [
                    'nombre_curso' => 'Crossfit',
                    'fecha_inicio' => '2023-03-22',
                    'fecha_fin' => '2023-05-01',
                    'pvp_curso' => 50,
                ],
                [
                    'nombre_curso' => 'Clase de cardio',
                    'fecha_inicio' => '2023-01-09',
                    'fecha_fin' => '2023-12-22',
                    'pvp_curso' => 300,
                ],
                [
                    'nombre_curso' => 'Zumba',
                    'fecha_inicio' => '2023-05-01',
                    'fecha_fin' => '2023-09-01',
                    'pvp_curso' => 150,
                ]
            ]
        );
    }
}
