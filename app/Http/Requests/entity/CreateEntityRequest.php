<?php

namespace App\Http\Requests\entity;

use Illuminate\Foundation\Http\FormRequest;

class CreateEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'abbreviation' => ['required','string','max:255'],
            'description'=> ['required','string','max:255'],
            'active'=> ['true'],
        ];
    }
}