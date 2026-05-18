<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchTripRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'departure_city' => 'nullable|string|max:100',
            'arrival_city' => 'nullable|string|max:100',
            'date' => 'nullable|date|after_or_equal:today',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
            'seats' => 'nullable|integer|min:1'
        ];
    }
    
    public function messages(): array
    {
        return [
            'departure_city.max' => 'La ville de départ ne peut pas dépasser 100 caractères.',
            'arrival_city.max' => 'La ville d\'arrivée ne peut pas dépasser 100 caractères.',
            'date.after_or_equal' => 'La date doit être aujourd\'hui ou dans le futur.',
            'min_price.min' => 'Le prix minimum doit être supérieur à 0.',
            'max_price.min' => 'Le prix maximum doit être supérieur à 0.',
            'max_price.gte' => 'Le prix maximum doit être supérieur au prix minimum.',
            'seats.min' => 'Le nombre de places doit être au moins 1.'
        ];
    }
}