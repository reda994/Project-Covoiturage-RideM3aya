<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function trips()
    {
        $trips = Trip::with(['vehicle', 'bookings.passenger'])
            ->where('driver_id', auth()->id())
            ->orderBy('departure_datetime', 'desc')
            ->paginate(10);
        
        return view('driver.trips.index', compact('trips'));
    }
    
    public function bookings()
    {
        $bookings = Booking::with(['trip', 'passenger'])
            ->whereHas('trip', function($q) {
                $q->where('driver_id', auth()->id());
            })
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('driver.bookings.index', compact('bookings'));
    }
    
    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        
        return redirect()->route('driver.bookings')
            ->with('success', 'Réservation confirmée.');
    }
    
    public function rejectBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->route('driver.bookings')
            ->with('success', 'Réservation refusée.');
    }
}