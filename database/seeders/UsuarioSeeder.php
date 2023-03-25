<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
                [
                    'dni' => '00000000A',
                    'email' => 'usuario1@gmail.com',
                    'telefono' => '699999999',
                    'nombre' => 'John',
                    'apellidos' => 'Doe',
                    'fechaNacimiento' => '2000-04-12',
                    'password' => bcrypt('PasswordPrueba'),
                    'imagenPerfil' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'dni' => '00000000B',
                    'email' => 'usuario2@gmail.com',
                    'telefono' => '699999998',
                    'nombre' => 'Juan',
                    'apellidos' => 'Profundo',
                    'fechaNacimiento' => '1970-05-20',
                    'password' => bcrypt('PasswordPrueba'),
                    'imagenPerfil' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
                [
                    'dni' => '00000000C',
                    'email' => 'usuario3@gmail.com',
                    'telefono' => '+34699999990',
                    'nombre' => 'Pepe',
                    'apellidos' => 'Reina',
                    'fechaNacimiento' => '1960-11-02',
                    'password' => bcrypt('PasswordPrueba'),
                    'imagenPerfil' => 'https://img.freepik.com/free-icon/avatar_318-158392.jpg',
                ],
            ]
        );
    }
}
