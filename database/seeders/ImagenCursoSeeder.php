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
                    'referenciaCurso' => 1234566,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'referenciaCurso' => 1234567,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'referenciaCurso' => 1234568,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ]
            ]
        );
    }
}
