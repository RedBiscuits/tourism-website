<?php

namespace App\Http\Requests\Reservations;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
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
            'email' => 'required|email',
            'phone' => 'required|string',
            'tour_id' => 'required|integer|min:1|exists:tours,id',
            'date' => 'required|date',
            'hotel_name' => 'required|string',
            'room_uid' => 'required|string',
            'num_people' => 'required|integer|min:1',
            'invoice_id' => 'required|string',
        ];
    }
}
