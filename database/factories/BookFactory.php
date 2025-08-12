<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Crear ejemplo de por defecto del modelo.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'author' => fake()->name(),
            'category_id' => Category::factory(),
        ];
    }
}
