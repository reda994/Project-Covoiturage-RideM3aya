<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'profile_photo',
        'role', 'bio', 'is_active'
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Relations
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function tripsAsDriver()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }

    public function bookingsAsPassenger()
    {
        return $this->hasMany(Booking::class, 'passenger_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Accesseurs
    public function getAverageRatingAttribute()
    {
        return $this->reviewsReceived()->avg('rating') ?? 0;
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo 
            ? asset('storage/' . $this->profile_photo)
            : 'https://ui-avatars.com/api/?background=16a34a&color=fff&name=' . urlencode($this->name);
    }

    // Méthodes
    public function isDriver()
    {
        return in_array($this->role, ['driver', 'admin']);
    }

    public function isPassenger()
    {
        return true; // Tous les utilisateurs peuvent être passagers
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}