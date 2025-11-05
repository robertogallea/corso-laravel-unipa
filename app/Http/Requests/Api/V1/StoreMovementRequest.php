<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequest extends FormRequest
{

    public array $attributeMap = [
        'data.attributes.description' => 'description',
        'data.attributes.status' => 'status',
        'data.attributes.created_at' => 'created_at',
        'data.attributes.updated_at' => 'updated_at',
    ];

    public function mappedAttributes(): array
    {
        $mappedAttributes = [];

        foreach ($this->attributeMap as $inputAttribute => $outputAttribute) {
            if ($this->has($inputAttribute)) {
                $mappedAttributes[$outputAttribute] = $this->input($inputAttribute);
            }
        }

        $mappedAttributes['user_id'] = $this->user()->id;

        return $mappedAttributes;
    }

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
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:D,A,C',
            'data.attributes.created_at' => 'nullable|date',
            'data.attributes.updated_at' => 'nullable|date',
        ];
    }
}
