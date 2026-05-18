<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 'vehicle_id', 'departure_city', 'arrival_city',
        'departure_datetime', 'available_seats', 'price_per_seat',
        'description', 'status'
    ];

    protected $casts = [
        'departure_datetime' => 'datetime'
    ];

    // Relations
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accesseur pour les places disponibles (en tenant compte des réservations confirmées)
    public function getAvailableSeatsAttribute($value)
    {
        $bookedSeats = $this->bookings()
            ->where('status', 'confirmed')
            ->sum('seats_booked');
        
        return $value - $bookedSeats;
    }

    // Méthode pour mettre à jour le statut
    public function updateStatus()
    {
        if ($this->available_seats <= 0) {
            $this->update(['status' => 'full']);
        } elseif ($this->status === 'full' && $this->available_seats > 0) {
            $this->update(['status' => 'active']);
        }
    }
}