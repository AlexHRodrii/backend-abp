<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductoSeeder::class,
            CursoSeeder::class,
            UsuarioSeeder::class,
            InstalacionSeeder::class
            UsuarioSeeder::class,
            ImagenCursoSeeder::class,
            ImagenInstalacionSeeder::class,
            ImagenProductoSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
