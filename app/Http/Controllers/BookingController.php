<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, Trip $trip)
    {
        // Vérifier les places disponibles
        if ($trip->available_seats < $request->seats_booked) {
            return back()->with('error', 'Plus assez de places disponibles.');
        }

        $totalPrice = $trip->price_per_seat * $request->seats_booked;

        $booking = Booking::create([
            'trip_id' => $trip->id,
            'passenger_id' => auth()->id(),
            'seats_booked' => $request->seats_booked,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // Notifier le conducteur
        $trip->driver->notifications()->create([
            'type' => 'new_booking',
            'message' => "Nouvelle réservation pour le trajet {$trip->departure_city} → {$trip->arrival_city} par " . auth()->user()->name
        ]);

        return redirect()->route('my-bookings')
            ->with('success', 'Réservation effectuée ! En attente de confirmation.');
    }

    public function myBookings()
    {
        $bookings = Booking::with(['trip.driver', 'trip.vehicle'])
            ->where('passenger_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('bookings.index', compact('bookings'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);
        
        $booking->update(['status' => 'cancelled']);
        
        // Notifier le conducteur
        $booking->trip->driver->notifications()->create([
            'type' => 'booking_cancelled',
            'message' => "Réservation annulée par " . auth()->user()->name . " pour le trajet {$booking->trip->departure_city} → {$booking->trip->arrival_city}"
        ]);
        
        return redirect()->route('my-bookings')
            ->with('success', 'Réservation annulée avec succès.');
    }
}