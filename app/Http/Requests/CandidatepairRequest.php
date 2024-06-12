<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatepairRequest extends FormRequest
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
            'chairman' => 'required', 
            'vicechairman' => 'required',
            'vision' => 'required',
            'mission' => 'required',
            'photo' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [ 
            'chairman.required' => 'Chairman is required', 
            'vicechairman.required' => 'Vicechairman is required',
            'vision.required' => 'vision is required',
            'mission.required' => 'mission is required',
            'photo.required' => 'photo is required', 
            'photo.image' => 'photo is must image' 
        ];
    }

}
