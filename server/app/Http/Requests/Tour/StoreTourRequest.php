<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'duration' => 'required|string',
            'includes' => 'array',
            'excludes' => 'array',
            'options' => 'array',
            'options.*.name' => 'string',
            'options.*.price' => 'numeric|min:0',
        ];
    }
}
