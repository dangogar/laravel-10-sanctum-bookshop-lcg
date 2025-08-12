<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transformar la categoría en un array en formato JSON.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'books_count' => $this->whenCounted('books'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
