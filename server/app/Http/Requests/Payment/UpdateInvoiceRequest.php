<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'user_id' => 'integer',
            'payment_method_id' => 'integer',
            'amount' => 'numeric',
            'currency' => 'string',
            'status' => 'integer',
            'invoice_number' => 'string',
            'invoice_key' => 'string',
            'payment_method' => 'string',
        ];
    }
}
