<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;

class BookingPolicy
{
    public function cancel(User $user, Booking $booking): bool
    {
        return $user->id === $booking->passenger_id && 
               $booking->status === 'pending' &&
               $booking->trip->departure_datetime > now();
    }

    public function confirm(User $user, Booking $booking): bool
    {
        return $user->id === $booking->trip->driver_id && 
               $booking->status === 'pending';
    }

    public function reject(User $user, Booking $booking): bool
    {
        return $user->id === $booking->trip->driver_id && 
               $booking->status === 'pending';
    }
}