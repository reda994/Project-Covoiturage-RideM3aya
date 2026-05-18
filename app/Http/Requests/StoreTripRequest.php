<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isDriver();
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'departure_city' => 'required|string|max:100',
            'arrival_city' => 'required|string|max:100|different:departure_city',
            'departure_datetime' => 'required|date|after:now',
            'available_seats' => 'required|integer|min:1',
            'price_per_seat' => 'required|numeric|min:0|max:1000',
            'description' => 'nullable|string|max:500'
        ];
    }
    
    public function messages(): array
    {
        return [
            'vehicle_id.required' => 'Veuillez sélectionner un véhicule.',
            'vehicle_id.exists' => 'Le véhicule sélectionné n\'existe pas.',
            'departure_city.required' => 'La ville de départ est requise.',
            'arrival_city.required' => 'La ville d\'arrivée est requise.',
            'arrival_city.different' => 'La ville d\'arrivée doit être différente de la ville de départ.',
            'departure_datetime.required' => 'La date et l\'heure de départ sont requises.',
            'departure_datetime.after' => 'La date de départ doit être dans le futur.',
            'available_seats.required' => 'Le nombre de places est requis.',
            'available_seats.min' => 'Vous devez proposer au moins 1 place.',
            'price_per_seat.required' => 'Le prix par place est requis.',
            'price_per_seat.min' => 'Le prix doit être supérieur à 0.',
            'price_per_seat.max' => 'Le prix ne peut pas dépasser 1000 DH.',
            'description.max' => 'La description ne peut pas dépasser 500 caractères.'
        ];
    }
}