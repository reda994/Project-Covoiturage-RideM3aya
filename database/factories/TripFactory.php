<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        $cities = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Tétouan', 'Essaouira'];
        
        $departure = fake()->randomElement($cities);
        $arrival = fake()->randomElement(array_diff($cities, [$departure]));
        
        return [
            'departure_city' => $departure,
            'arrival_city' => $arrival,
            'departure_datetime' => fake()->dateTimeBetween('now', '+30 days'),
            'available_seats' => fake()->numberBetween(1, 4),
            'price_per_seat' => fake()->randomFloat(2, 20, 200),
            'description' => fake()->optional(0.7)->sentence(),
            'status' => 'active',
        ];
    }
}