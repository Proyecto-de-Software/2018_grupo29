<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Patient;

class StorePatient extends FormRequest
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
        $id = $this->input('id');

        return [
            'first_name' => 'required|min:3|max:60',
            'last_name' => 'required|min:3|max:60',
            'birthdate' => 'required|date',
            'home' => 'required|min:3|max:60',
            'dni_number' =>  [
                'required',
                'numeric',
                'digits_between:6,10',
                
                # Esto es para que no tire error diciendo que el dni ya esta en uso.
                Rule::unique('patients')->ignore($id),
            ],
            'phone_number' => 'nullable|numeric|digits_between:7,15',
            'medical_history_number' => [
                'nullable',
                'numeric',
                'digits_between:1,6',
                Rule::unique('patients')->ignore($id),
            ],
            'folder_number' => [
                'nullable',
                'numeric',
                'digits_between:1,5',
                Rule::unique('patients')->ignore($id),
            ],
            'location_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio',
            'first_name.min' => 'El nombre es demasiado corto',
            'first_name.max' => 'El nombre es demasiado largo',
            'last_name.required' => 'El apellido es obligatorio',
            'last_name.min' => 'El apellido es demasiado corto',
            'last_name.max' => 'El apellido es demasiado largo',
            'home.required' => 'El domicilio es obligatorio',
            'home.min' => 'El domicilio es demasiado corto',
            'home.max' => 'El domicilio es demasiado largo',
            'dni_number.required' => 'El número de documento es obligatorio',
            'dni_number.numeric' => 'El número de documento sólo puede tener números',
            'dni_number.digits_between' => 'El número de documento debe tener entre 6 y 10 dígitos',
            'dni_number.unique' => 'El número de documento debe ser único',
            'phone_number.numeric' => 'El número de teléfono sólo puede tener números',
            'phone_number.digits_between' => 'El número de teléfono debe tener entre 7 y 15 dígitos',
            'medical_history_number.numeric' => 'El número de historia clínica sólo puede tener números',
            'medical_history_number.digits_between' => 'El número de historia clínica debe tener máximo 6 dígitos',
            'medical_history_number.unique' => 'El número de historia clínica debe ser único',
            'folder_number.numeric' => 'El número de carpeta sólo puede tener números',
            'folder_number.digits_between' => 'El número de carpeta debe tener máximo 5 dígitos',
            'folder_number.unique' => 'El número de carpeta debe ser único',
            'location_id.required' => 'La localidad es obligatoria',
        ];
    }
}
