<?php

// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 'passenger_id', 'seats_booked', 'total_price', 'status'
    ];

    // Relations
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Méthodes
    public function canBeReviewed()
    {
        return $this->status === 'confirmed' && 
               $this->trip->departure_datetime < now() &&
               !$this->review;
    }
}
