<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class FounderDataRequest extends FormRequest
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
            'service' => ['required'],
            'name' => ['required'],
            'lastname' => ['required'],
            'address' => ['required'],
            'country' => ['required'],
            'contact' => ['required'],
            'email' => ['required'],
            'shelter_type' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'service.required' => 'Obavezan podatak',
            'name.required' => 'Obavezan podatak',
            'lastname.required' => 'Obavezan podatak',
            'address.required' => 'Obavezan podatak',
            'country.required' => 'Obavezan podatak',
            'contact.required' => 'Obavezan podatak',
            'email.required' => 'Obavezan podatak',
            'shelter_type.required' => 'Obavezan podatak',
        ];
    }
}
