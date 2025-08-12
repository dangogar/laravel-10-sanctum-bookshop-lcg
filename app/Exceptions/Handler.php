<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * La lista de los inputs que nunca se envían a la sesión en excepciones de validación.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registrar los callbacks de manejo de excepciones para la aplicación.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                // Manejo de excepciones para el modelo
                if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recurso no encontrado',
                        'error' => 'El recurso solicitado no existe'
                    ], 404);
                }

                // Manejo de excepciones para la página no encontrada
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Página no encontrada',
                        'error' => 'La página solicitada no existe'
                    ], 404);
                }

                // Manejo de excepciones para la validación
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error de validación',
                        'errors' => $e->errors()
                    ], 422);
                }

                // Manejo de excepciones para la autenticación
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No autenticado',
                        'error' => 'Debe iniciar sesión para acceder a este recurso'
                    ], 401);
                }

                // Manejo de excepciones para la autorización
                if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No autorizado',
                        'error' => 'No tiene permisos para realizar esta acción'
                    ], 403);
                }

                // Respuesta de error por defecto
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor',
                    'error' => config('app.debug') ? $e->getMessage() : 'Ha ocurrido un error inesperado'
                ], 500);
            }
        });
    }
}
