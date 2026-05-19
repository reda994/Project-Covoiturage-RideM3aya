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
        if ($trip->driver_id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas réserver votre propre trajet.');
        }

        $existingBooking = Booking::where('trip_id', $trip->id)
            ->where('passenger_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return back()->with('error', 'Vous avez déjà une réservation active pour ce trajet.');
        }

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $trip) {
            $lockedTrip = Trip::lockForUpdate()->find($trip->id);

            if ($lockedTrip->available_seats < $request->seats_booked) {
                return back()->with('error', 'Plus assez de places disponibles.');
            }

            $totalPrice = $lockedTrip->price_per_seat * $request->seats_booked;

            $booking = Booking::create([
                'trip_id' => $lockedTrip->id,
                'passenger_id' => auth()->id(),
                'seats_booked' => $request->seats_booked,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            $lockedTrip->available_seats -= $request->seats_booked;
            $lockedTrip->save();

            $lockedTrip->driver->notifications()->create([
                'type' => 'new_booking',
                'message' => "Nouvelle réservation pour le trajet {$lockedTrip->departure_city} → {$lockedTrip->arrival_city} par " . auth()->user()->name
            ]);

            return redirect()->route('my-bookings')
                ->with('success', 'Réservation effectuée ! En attente de confirmation.');
        });
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
        if ($booking->passenger_id !== auth()->id()) {
            abort(403);
        }
        
        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Cette réservation est déjà annulée.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            
            $trip = Trip::lockForUpdate()->find($booking->trip_id);
            $trip->available_seats += $booking->seats_booked;
            $trip->save();
            
            $trip->driver->notifications()->create([
                'type' => 'booking_cancelled',
                'message' => "Réservation annulée par " . auth()->user()->name . " pour le trajet {$trip->departure_city} → {$trip->arrival_city}"
            ]);
        });
        
        return redirect()->route('my-bookings')
            ->with('success', 'Réservation annulée avec succès.');
    }
}