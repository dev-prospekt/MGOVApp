<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AnimalPostRequest extends FormRequest
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
            'quantity' => "required",
            'location' => "required",
            'documents' => "required|max:10000",
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'Količina je obavezan podatak',
            'location.required' => 'Lokacija je obavezan podatak',
            'documents.required' => 'Dokument je obavezan podatak.',
        ];
    }
}
