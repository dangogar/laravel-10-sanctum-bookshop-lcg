<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
        ];
    }

    /**
     * Obtener mensajes personalizados para errores de validación.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del libro es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'author.required' => 'El autor es obligatorio.',
            'author.string' => 'El autor debe ser una cadena de texto.',
            'author.max' => 'El autor no puede tener más de 255 caracteres.',
        ];
    }
}
