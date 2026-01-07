<?php

namespace App\Http\Requests\prontuario;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Debes seleccionar un archivo.',
            'file.mimes' => 'Solo se permite archivos PDF.',
            'file.max' => 'El archivo no debe superar los 5MB.',
        ];
    }
}
