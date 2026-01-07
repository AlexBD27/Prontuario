<?php

namespace App\Http\Requests\prontuario;

use Illuminate\Foundation\Http\FormRequest;

class EstablishInitNumberRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_giro' => 'required|integer',
            'numero_inicial' => 'required|integer|min:1',
            'area_interno' => 'nullable|exists:areas,id',
            'area_publico' => 'nullable|exists:areas,id',
            'intern_document' => 'nullable|exists:doc_types,id',
            'extern_document' => 'nullable|exists:doc_types,id',
            'public_document' => 'nullable|exists:doc_types,id',
            'groups_document' => 'nullable|exists:doc_types,id',
            'personal_document' => 'nullable|exists:doc_types,id',
            'grupo' => 'nullable|exists:groups,id',
            'worker_id' => 'nullable|exists:workers,id',
        ];
    }
}
