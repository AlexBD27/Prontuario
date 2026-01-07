<?php

namespace App\Http\Requests\doctype;

use Illuminate\Foundation\Http\FormRequest;

class EditDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'abbreviation' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'giro_types' => ['sometimes', 'array'],
            'giro_types.*' => ['exists:giro_types,id'],
            'active' => 'nullable'
        ];
    }
}
