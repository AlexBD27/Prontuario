<?php

namespace App\Http\Requests\subgroup;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubgroupRequest extends FormRequest
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
            'group_id' => 'required|exists:groups,id', 
            'subgroup_name' => 'required|string|max:255',
            'subgroup_abbreviation' => 'required|string|max:255',
        ];
    }
}
