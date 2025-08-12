<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Ejecutar la creación de datos de prueba en la base de datos.
     */
    public function run(): void
    {
        $books = [
            [
                'name' => 'Don Quijote de la Mancha',
                'author' => 'Miguel de Cervantes',
                'category' => 'Ficción'
            ],
            [
                'name' => 'Cien años de soledad',
                'author' => 'Gabriel García Márquez',
                'category' => 'Ficción'
            ],
            [
                'name' => 'El señor de los anillos',
                'author' => 'J.R.R. Tolkien',
                'category' => 'Fantasía'
            ],
            [
                'name' => 'Harry Potter y la piedra filosofal',
                'author' => 'J.K. Rowling',
                'category' => 'Fantasía'
            ],
            [
                'name' => '1984',
                'author' => 'George Orwell',
                'category' => 'Ciencia Ficción'
            ],
            [
                'name' => 'El nombre de la rosa',
                'author' => 'Umberto Eco',
                'category' => 'Misterio'
            ],
            [
                'name' => 'El amor en los tiempos del cólera',
                'author' => 'Gabriel García Márquez',
                'category' => 'Romance'
            ],
            [
                'name' => 'Breve historia del tiempo',
                'author' => 'Stephen Hawking',
                'category' => 'Ciencia'
            ],
            [
                'name' => 'El arte de la guerra',
                'author' => 'Sun Tzu',
                'category' => 'Filosofía'
            ],
            [
                'name' => 'Veinte poemas de amor',
                'author' => 'Pablo Neruda',
                'category' => 'Poesía'
            ],
            [
                'name' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'category' => 'Biografía'
            ],
            [
                'name' => 'Los 7 hábitos de la gente altamente efectiva',
                'author' => 'Stephen Covey',
                'category' => 'Autoayuda'
            ],
            [
                'name' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'category' => 'Tecnología'
            ],
            [
                'name' => 'El arte de la cocina francesa',
                'author' => 'Julia Child',
                'category' => 'Cocina'
            ],
            [
                'name' => 'Viaje al centro de la Tierra',
                'author' => 'Jules Verne',
                'category' => 'Ciencia Ficción'
            ],
        ];

        foreach ($books as $bookData) {
            $category = Category::where('name', $bookData['category'])->first();
            
            if ($category) {
                Book::create([
                    'name' => $bookData['name'],
                    'author' => $bookData['author'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
