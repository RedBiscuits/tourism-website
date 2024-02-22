<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTourRequest extends FormRequest
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
            'name' => 'string',
            'description' => 'string',
            'location' => 'string',
            'duration' => 'string',
            'includes' => 'array',
            'excludes' => 'array',
            'price' => 'numeric|min:1',
            'media' => 'array',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
