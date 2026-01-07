<?php

namespace App\Http\Requests\publictype;

use Illuminate\Foundation\Http\FormRequest;

class CreatePublicTypeRequest extends FormRequest
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
