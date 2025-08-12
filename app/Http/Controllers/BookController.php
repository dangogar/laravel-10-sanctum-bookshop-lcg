<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Mostrar una lista de los libros.
     */
    public function index(): JsonResponse
    {
        $books = Book::with('category')->get();
        
        return response()->json([
            'success' => true,
            'data' => BookResource::collection($books),
            'message' => 'Libros obtenidos correctamente'
        ]);
    }

    /**
     * Crear un nuevo libro.
     */
    public function store(BookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());
        $book->load('category');
        
        return response()->json([
            'success' => true,
            'data' => new BookResource($book),
            'message' => 'Libro creado correctamente'
        ], 201);
    }

    /**
     * Mostrar el libro especificado.
     */
    public function show(Book $book): JsonResponse
    {
        $book->load('category');
        
        return response()->json([
            'success' => true,
            'data' => new BookResource($book),
            'message' => 'Libro obtenido correctamente'
        ]);
    }

    /**
     * Actualizar el libro especificado.
     */
    public function update(BookRequest $request, Book $book): JsonResponse
    {
        $book->update($request->validated());
        $book->load('category');
        
        return response()->json([
            'success' => true,
            'data' => new BookResource($book),
            'message' => 'Libro actualizado correctamente'
        ]);
    }

    /**
     * Eliminar el libro especificado.
     */
    public function destroy(Book $book): JsonResponse
    {
        $book->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Libro eliminado correctamente'
        ]);
    }
}
