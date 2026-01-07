<?php

namespace App\Http\Requests\prontuario;

use Illuminate\Foundation\Http\FormRequest;

class EditProntuarioRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'folios' => 'required|numeric|min:1', 
            'tipo_giro' => 'required|string', 
            'document_id' => 'required|exists:doc_types,id', 
            'subject' => 'required|string|max:255',
            'area' => 'nullable|exists:areas,id', 
            'grupo' => 'nullable|exists:groups,id',
            'subgrupo' => 'nullable|exists:subgroups,id',
            'entidad_externa' => 'nullable|exists:entities,id',
            'tipo_publico' => 'nullable|exists:public_types,id',
            'comment' => 'nullable|string|max:255',
            'approved'=> 'nullable',
        ];
    }
}
