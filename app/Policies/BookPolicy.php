<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Determinar si el usuario puede ver cualquier modelo.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determinar si el usuario puede ver el modelo.
     */
    public function view(User $user, Book $book): bool
    {
        return true;
    }

    /**
     * Determinar si el usuario puede crear modelos.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determinar si el usuario puede actualizar el modelo.
     */
    public function update(User $user, Book $book): bool
    {
        return true;
    }

    /**
     * Determinar si el usuario puede eliminar el modelo.
     */
    public function delete(User $user, Book $book): bool
    {
        return true;
    }
}
