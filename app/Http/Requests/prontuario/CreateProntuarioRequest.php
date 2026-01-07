<?php

namespace App\Http\Requests\prontuario;

use Illuminate\Foundation\Http\FormRequest;

class CreateProntuarioRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'folios' => 'required|numeric|min:1', 
            // 'tipo_giro' => 'required|exists:giro_types,id', 
            'tipo_giro' => 'required|string|max:255',
            'document_id' => 'required|exists:doc_types,id', 
            'subject' => 'required|string|max:255',
            'area' => 'nullable|exists:areas,id', 
            'grupo' => 'nullable|exists:groups,id',
            'subgrupo' => 'nullable|exists:subgroups,id',
            'entidad_externa' => 'nullable|exists:entities,id',
            'tipo_publico' => 'nullable|exists:public_types,id',
        ];
    }

    public function messages()
    {
        return [
            'folios.required' => 'El campo folios es obligatorio.',
            'folios.numeric' => 'El campo folios debe ser un número.',
            'folios.min' => 'El campo folios debe ser al menos 1.',
            'tipo_giro.required' => 'El campo tipo de giro es obligatorio.',
            'tipo_giro.string' => 'El campo tipo de giro debe ser una cadena de texto.',
            'document_id.required' => 'El campo tipo de documento es obligatorio.',
            'document_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'subject.required' => 'El campo asunto es obligatorio',
            'area.exists' => 'El área seleccionada no es válida.',    
            'grupo.exists' => 'El grupo seleccionado no es válido.',
            'subgrupo.exists' => 'El subgrupo seleccionado no es válido.',
            'entidad_externa.exists' => 'La entidad externa seleccionada no es válida.',
        ];
    }
    
}
