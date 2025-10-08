<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0.01|max:999.99',
        ];
    }

    public function messages(): array
    {
        return [
            'name' => [
                'required' => 'Devi inserire un nome per :attribute',
                'string' => 'Il campo :attribute deve essere una stringa valida',
                'min' => 'Il campo nome :attribute essere di almeno 3 caratteri'
            ]
        ];
    }
}
