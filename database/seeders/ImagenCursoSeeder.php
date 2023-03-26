<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenCursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('imagenCurso')->insert([
                [
                    'referenciaCurso' => 1,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'referenciaCurso' => 2,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'referenciaCurso' => 2,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ]
            ]
        );
    }
}
