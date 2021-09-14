<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AnimalItemFilePostRequest extends FormRequest
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
            'filenames' => "required|mimes:pdf|max:10000",
            'file_name' => "required",
        ];
    }

    public function messages()
    {
        return [
            'filenames.required' => 'Dokument mora biti ispunjen.',
            'filenames.mimes' => 'Za upload možete koristiti samo PDF.',
            'file_name.required' => 'Naziv dokumenta mora biti ispunjen.',
        ];
    }
}
