<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Ejecutar la creación de datos de prueba en la base de datos.
     */
    public function run(): void
    {
        $categories = [
            'Ficción',
            'No Ficción',
            'Ciencia Ficción',
            'Fantasía',
            'Misterio',
            'Romance',
            'Historia',
            'Ciencia',
            'Filosofía',
            'Poesía',
            'Biografía',
            'Autoayuda',
            'Tecnología',
            'Cocina',
            'Viajes',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
