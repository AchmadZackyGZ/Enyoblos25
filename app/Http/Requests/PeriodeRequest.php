<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'name' => 'min:3',
            'year' => 'required',
            'year' => 'numeric',
            'election_status' => 'required',
            'registration_status' => 'required',
            'registration_page' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'name.min' => 'name min 3 character',
            'year.required' => 'year is required',
            'year.numeric' => 'year is must numeric',
            'election_status.required' => 'election_status is required',
            'registration_status.required' => 'registration_status is required',
            'registration_page.required' => 'registration_page is required'
        ];
    }

}
