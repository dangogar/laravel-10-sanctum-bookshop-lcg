<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Category;
use App\Policies\BookPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Los modelos y sus políticas de autorización.
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Book::class => BookPolicy::class,
    ];

    /**
     * Registrar los servicios de autenticación y autorización.
     */
    public function boot(): void
    {
        //
    }
}
