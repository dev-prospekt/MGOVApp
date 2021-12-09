<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class DocumentationStoreRequest extends FormRequest
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
            'state_recive' => ['required'],
            'state_recive_desc' => ['required'],
            'state_found' => ['required', 'max:5'],
            'state_found_desc' => ['required'],
            'state_reason' => ['required'],
            'state_reason_desc' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'state_recive.required' => 'Obavezan podatak',
            'state_recive_desc.required' => 'Obavezan podatak',
            'shelter_code.required' => 'Obavezan podatak',
            'state_found.required' => 'Obavezan podatak',
            'state_found_desc.required' => 'Obavezan podatak',
            'state_reason.required' => 'Obavezan podatak',
            'state_reason_desc.required' => 'Obavezan podatak',
        ];
    }
}
