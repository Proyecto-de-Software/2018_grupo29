<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Consultation;

class StoreConsultation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'diagnostic' => 'required|min:1|max:255',
            'reason_id' => 'required|numeric',
            'date' => 'required|date',
            'was_internment' => 'required|numeric',
            'derivation_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'diagnostic.required' => 'El diagnóstico es obligatorio',
            'diagnostic.min' => 'El diagnóstico es demasiado corto',
            'diagnostic.max' => 'El diagnóstico es demasiado largo',
            'reason_id.required' => 'El motivo es obligatorio',
            'reason_id.numeric' => 'El motivo debe ser una de las opciones en pantalla',
            'date.required' => 'La fecha es obligatoria',
            'was_internment.required' => 'Hubo internación es obligatorio',
            'was_internment.numeric' => 'Hubo internación debe ser una de las opciones en pantalla',
            'derivation_id.required' => 'La institución es obligatoria',
            'derivation_id.numeric' => 'La institución debe ser una de las opciones en pantalla',
        ];
    }
}
