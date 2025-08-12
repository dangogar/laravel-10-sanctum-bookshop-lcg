<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecutar la creación de datos de prueba en la base de datos.
     */
    public function run(): void
    {
        // Crear 10 usuarios de prueba (descomentar para crear)
        //\App\Models\User::factory(10)->create();

        // Crear un usuario de prueba
        \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'password' => 'password123'
        ]);

        // Crear categorías y libros de prueba por orden de ejecución
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}
