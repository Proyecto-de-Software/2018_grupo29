<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfiguration extends FormRequest
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
            'pagination' => 'required|numeric',
            'title' => 'required|min:3|max:80',
            'maintenance' => 'required|numeric',
            'email' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.min' => 'El título es demasiado corto',
            'title.max' => 'El título es demasiado largo',
            'pagination.required' => 'La paginación es obligatoria',
            'pagination.numeric' => 'La paginación debe ser numerica',
            'maintenance.required' => 'El estado del sitio es obligatorio',
            'maintenance.numeric' => 'El estado del sitio debe ser una de las opciones en pantalla',
            'email.required' => 'El correo electrónico es obligatorio',
        ];
    }
}
