<?php

namespace App\Http\Requests\prontuario;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProntuarioRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255',
        ];
    }
}
