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
                    'nombreCurso' => 'Crossfit',
                    'fechaInicio' => '2023-03-22',
                    'fechaFin' => '2023-05-01',
                    'pvpCurso' => 50,
                ],
                [
                    'nombreCurso' => 'Clase de cardio',
                    'fechaInicio' => '2023-01-09',
                    'fechaFin' => '2023-12-22',
                    'pvpCurso' => 300,
                ],
                [
                    'nombreCurso' => 'Zumba',
                    'fechaInicio' => '2023-05-01',
                    'fechaFin' => '2023-09-01',
                    'pvpCurso' => 150,
                ]
            ]
        );
    }
}
