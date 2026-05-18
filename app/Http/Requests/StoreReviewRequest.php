<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        $booking = $this->route('booking');
        return $booking && $booking->passenger_id === $this->user()->id && $booking->canBeReviewed();
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ];
    }
    
    public function messages(): array
    {
        return [
            'rating.required' => 'Veuillez donner une note.',
            'rating.min' => 'La note doit être comprise entre 1 et 5.',
            'rating.max' => 'La note doit être comprise entre 1 et 5.',
            'comment.max' => 'Le commentaire ne peut pas dépasser 500 caractères.'
        ];
    }
}