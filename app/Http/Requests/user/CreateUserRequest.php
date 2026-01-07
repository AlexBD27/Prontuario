<?php

namespace App\Http\Requests\user;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:8'],
            'position' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
            'area' => ['nullable'],
            'tipo_grupo' => ['nullable'],
            'grupo' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.max' => 'El DNI no puede tener más de 8 caracteres.',

            'position.required' => 'El campo posición es obligatorio.',
            'position.string' => 'El campo posición debe ser una cadena de texto.',
            'position.max' => 'La posición no puede tener más de 255 caracteres.',

            'email.required' => 'El nombre de usuario es obligatorio.',
            'email.string' => 'El nombre de usuario debe ser una cadena de texto.',
            'email.max' => 'El nombre de usuario no puede tener más de 255 caracteres.',
            'email.unique' => 'Este nombre de usuario ya está registrado.',

            'password.required' => 'El campo contraseña es obligatorio.',
        ];
    }
}
