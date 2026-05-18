<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Trip;

class TripPolicy
{
    public function update(User $user, Trip $trip): bool
    {
        return $user->id === $trip->driver_id && 
               $trip->departure_datetime > now() &&
               $trip->status !== 'cancelled';
    }

    public function cancel(User $user, Trip $trip): bool
    {
        return $user->id === $trip->driver_id && 
               $trip->departure_datetime > now() &&
               $trip->status !== 'cancelled';
    }
}