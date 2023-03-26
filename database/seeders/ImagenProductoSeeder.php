<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('imagenProducto')->insert([
                [
                    'referenciaProducto' => 3234566,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'referenciaProducto' => 3234567,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'referenciaProducto' => 3234568,
                    'url' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ]
            ]
        );
    }
}
