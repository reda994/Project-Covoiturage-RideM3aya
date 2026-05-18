<?php
// app/Http/Requests/StoreVehicleRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isDriver();
    }

    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'color' => 'required|string|max:30',
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'seats_total' => 'required|integer|min:1|max:9'
        ];
    }
}
