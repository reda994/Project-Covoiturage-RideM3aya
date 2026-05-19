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
        'role', 'bio', 'is_active',
        'license_number', 'license_issue_date', 'license_category', 'license_country',
        'license_photo_recto', 'license_photo_verso', 'license_selfie'
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'license_issue_date' => 'date',
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

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
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