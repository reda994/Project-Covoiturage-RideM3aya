<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $brands = ['Dacia', 'Renault', 'Peugeot', 'Volkswagen', 'Toyota', 'Hyundai'];
        $models = ['Logan', 'Sandero', 'Clio', '208', 'Golf', 'Corolla', 'i10'];
        
        return [
            'brand' => fake()->randomElement($brands),
            'model' => fake()->randomElement($models),
            'color' => fake()->colorName(),
            'plate_number' => strtoupper(fake()->bothify('??-###-##')),
            'seats_total' => fake()->numberBetween(4, 7),
        ];
    }
}