<?php

namespace App\Http\Requests\Option;

use Illuminate\Foundation\Http\FormRequest;

class CreateOptionRequest extends FormRequest
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
            'price' => 'required||min:0',
            'tour_id' => 'required|integer|min:1|exists:tours,id',
        ];
    }
}
