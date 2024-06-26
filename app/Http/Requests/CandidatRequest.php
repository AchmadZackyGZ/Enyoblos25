<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatRequest extends FormRequest
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
            'phone' => 'required', 
            'photo' => 'required',
            'student_card' => 'required',
            'organization_letter' => 'required',
            'lkmtd_letter' => 'required',
            'transcript' => 'required'
        ];
    }

    public function messages(): array
    {
        return [ 
            'phone.required' => 'Phone is required', 
            'photo.required' => 'Photo is required',
            'student_card.required' => 'Student Card is required',
            'organization_letter.required' => 'Organization Letter is required',
            'lkmtd_letter.required' => 'LKMTD Letter is required',
            'transcript.required' => 'Transcript is required', 
        ];
    }

    public function attributes(): array
    {
        return [ 
            'phone' => 'Phone', 
            'photo' => 'Photo',
            'student_card' => 'Student Card',
            'organization_letter' => 'Organization Letter',
            'lkmtd_letter' => 'LKMTD Letter',
            'transcript' => 'Transcript' 
        ];
    }
}
