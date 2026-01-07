<?php

namespace App\Http\Requests\group;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'group_type_id' => 'required|exists:group_types,id', 
            'area_id' => 'required|exists:areas,id', 
            'group_name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:255',
        ];
    }
}
