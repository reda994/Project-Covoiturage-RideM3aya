<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isPassenger();
    }

    public function rules(): array
    {
        return [
            'seats_booked' => 'required|integer|min:1|max:' . $this->trip->available_seats
        ];
    }
    
    public function messages(): array
    {
        return [
            'seats_booked.required' => 'Veuillez indiquer le nombre de places.',
            'seats_booked.min' => 'Vous devez réserver au moins 1 place.',
            'seats_booked.max' => 'Vous ne pouvez pas réserver plus de places que disponibles.'
        ];
    }
}