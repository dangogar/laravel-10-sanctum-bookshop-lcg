<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;
    private string $token;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('auth_token')->plainTextToken;
        $this->category = Category::factory()->create();
    }
    //test para obtener todos los libros
    public function test_user_can_get_books(): void
    {
        Book::factory()->count(3)->create(['category_id' => $this->category->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/books');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => ['id', 'name', 'author', 'category', 'created_at', 'updated_at']
                    ],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Libros obtenidos correctamente'
                ]);

        $this->assertCount(3, $response->json('data'));
    }

    //test para crear un libro
    public function test_user_can_create_book(): void
    {
        $bookData = [
            'name' => 'Nuevo Libro',
            'author' => 'Nuevo Autor',
            'category_id' => $this->category->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/books', $bookData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'data' => ['id', 'name', 'author', 'category', 'created_at', 'updated_at'],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Libro creado correctamente',
                    'data' => [
                        'name' => 'Nuevo Libro',
                        'author' => 'Nuevo Autor'
                    ]
                ]);

        $this->assertDatabaseHas('books', [
            'name' => 'Nuevo Libro',
            'author' => 'Nuevo Autor',
            'category_id' => $this->category->id,
        ]);
    }

    //test para crear un libro sin campos requeridos
    public function test_user_cannot_create_book_without_required_fields(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/books', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name', 'author', 'category_id']);
    }

    //test para crear un libro con una categoría inválida
    public function test_user_cannot_create_book_with_invalid_category(): void
    {
        $bookData = [
            'name' => 'Nuevo Libro',
            'author' => 'Nuevo Autor',
            'category_id' => 999, // Non-existent category
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/books', $bookData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['category_id']);
    }

    //test para obtener un libro específico
    public function test_user_can_get_single_book(): void
    {
        $book = Book::factory()->create(['category_id' => $this->category->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => ['id', 'name', 'author', 'category', 'created_at', 'updated_at'],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Libro obtenido correctamente',
                    'data' => [
                        'id' => $book->id,
                        'name' => $book->name,
                        'author' => $book->author
                    ]
                ]);
    }

    //test para actualizar un libro
    public function test_user_can_update_book(): void
    {
        $book = Book::factory()->create(['category_id' => $this->category->id]);

        $updateData = [
            'name' => 'Libro Actualizado',
            'author' => 'Autor Actualizado',
            'category_id' => $this->category->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/books/' . $book->id, $updateData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => ['id', 'name', 'author', 'category', 'created_at', 'updated_at'],
                    'message'
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Libro actualizado correctamente',
                    'data' => [
                        'name' => 'Libro Actualizado',
                        'author' => 'Autor Actualizado'
                    ]
                ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'name' => 'Libro Actualizado',
            'author' => 'Autor Actualizado',
        ]);
    }

    //test para eliminar un libro
    public function test_user_can_delete_book(): void
    {
        $book = Book::factory()->create(['category_id' => $this->category->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Libro eliminado correctamente'
                ]);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    //test para verificar que un usuario no autenticado no pueda acceder a las rutas protegidas
    public function test_user_cannot_access_books_without_token(): void
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(401);
    }
}
