<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ShelterPostRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'shelter_code' => ['required', 'max:5'],
            'place_zip' => ['required'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Naziv je obavezan podatak',
            'email.required' => 'Email je obavezan podatak',
            'shelter_code.required' => 'Šifra oporavilišta je obavezan podatak',
            'place_zip.required' => 'Mjesto i poštanski broj je obavezan podatak',
            'address.required' => 'Adresa je obavezan podatak',
        ];
    }
}
