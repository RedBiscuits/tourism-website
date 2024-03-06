<?php

namespace App\Http\Requests\Reservations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('sanctum')->check();
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
            'email' => 'email',
            'phone' => 'string',
            'tour_id' => 'integer|min:1|exists:tours,id',
            'date' => 'date',
            'hotel_name' => 'string',
            'room_uid' => 'string',
            'num_people' => 'integer|min:1',
            'total_amount' => 'numeric|min:1',
            'invoice_id' => 'string',
        ];
    }
}
