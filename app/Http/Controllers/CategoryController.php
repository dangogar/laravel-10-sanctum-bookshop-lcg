<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Mostrar una lista de las categorías.
     */
    public function index(): JsonResponse
    {
        $categories = Category::withCount('books')->get();
        
        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories),
            'message' => 'Categorías obtenidas correctamente'
        ]);
    }

    /**
     * Crear una nueva categoría.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'message' => 'Categoría creada correctamente'
        ], 201);
    }

    /**
     * Mostrar la categoría especificada.
     */
    public function show(Category $category): JsonResponse
    {
        $category->load('books');
        
        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'message' => 'Categoría obtenida correctamente'
        ]);
    }

    /**
     * Actualizar la categoría especificada.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'message' => 'Categoría actualizada correctamente'
        ]);
    }

    /**
     * Eliminar la categoría especificada.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Categoría eliminada correctamente'
        ]);
    }
}
