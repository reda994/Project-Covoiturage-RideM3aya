<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'brand', 'model', 'color', 'plate_number', 'seats_total',
        'year', 'fuel_type', 'consumption', 'carte_grise', 'insurance',
        'insurance_expiry', 'photos', 'options'
    ];

    protected $casts = [
        'insurance_expiry' => 'date',
        'photos' => 'array',
        'options' => 'array',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}