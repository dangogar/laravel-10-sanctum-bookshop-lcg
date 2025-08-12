<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
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
    public function view(User $user, Category $category): bool
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
    public function update(User $user, Category $category): bool
    {
        return true;
    }

    /**
     * Determinar si el usuario puede eliminar el modelo.
     */
    public function delete(User $user, Category $category): bool
    {
        return true;
    }
}
