<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AnimalInvasiveTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'latin_name' => ['required'],
            'animal_type' => ['required'],
            'animal_category' => ['required'],
            'animal_system_category' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Obavezan podatak',
            'latin_name.required' => 'Obavezan podatak',
            'animal_type.required' => 'Obavezan podatak',
            'animal_category.required' => 'Obavezan podatak',
            'animal_system_category.required' => 'Obavezan podatak',
        ];
    }
}
