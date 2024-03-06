<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
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
            'payment_method_id' => 'required|numeric|min:1',
            'amount' => 'required|integer|min:1',
            'payment_number' => 'required|numeric|min:01000000000',
            'reservation_id' => 'required|string|exists:reservations,uid',
            'currency' => 'required|string|in:USD,EGP',
            'name' => 'required|string',
            'email' => 'required|email',
            'city' => 'required|string',
        ];
    }
}
