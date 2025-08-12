<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('auth_token')->plainTextToken;
    }

    //test para obtener todas las categorías
    public function test_user_can_get_categories(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/categories');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => ['id', 'name', 'books_count', 'created_at', 'updated_at']
                    ],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Categorías obtenidas correctamente'
                ]);

        $this->assertCount(3, $response->json('data'));
    }

    //test para crear una categoría
    public function test_user_can_create_category(): void
    {
        $categoryData = ['name' => 'Nueva Categoría'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/categories', $categoryData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'data' => ['id', 'name', 'created_at', 'updated_at'],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Categoría creada correctamente',
                    'data' => ['name' => 'Nueva Categoría']
                ]);

        $this->assertDatabaseHas('categories', ['name' => 'Nueva Categoría']);
    }

    //test para crear una categoría sin nombre
    public function test_user_cannot_create_category_without_name(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/categories', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name']);
    }

    //test para crear una categoría duplicada
    public function test_user_cannot_create_duplicate_category(): void
    {
        Category::factory()->create(['name' => 'Categoría Existente']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/categories', ['name' => 'Categoría Existente']);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name']);
    }

    //test para obtener una categoría específica
    public function test_user_can_get_single_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/categories/' . $category->id);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => ['id', 'name', 'created_at', 'updated_at'],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Categoría obtenida correctamente',
                    'data' => ['id' => $category->id, 'name' => $category->name]
                ]);
    }

    //test para actualizar una categoría
    public function test_user_can_update_category(): void
    {
        $category = Category::factory()->create(['name' => 'Categoría Original']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/categories/' . $category->id, ['name' => 'Categoría Actualizada']);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => ['id', 'name', 'created_at', 'updated_at'],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Categoría actualizada correctamente',
                    'data' => ['name' => 'Categoría Actualizada']
                ]);

        $this->assertDatabaseHas('categories', ['name' => 'Categoría Actualizada']);
    }

    //test para eliminar una categoría
    public function test_user_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/categories/' . $category->id);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Categoría eliminada correctamente'
                ]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    //test para verificar que un usuario no autenticado no pueda acceder a las rutas protegidas
    public function test_user_cannot_access_categories_without_token(): void
    {
        $response = $this->getJson('/api/categories');

        $response->assertStatus(401);
    }
}
