<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        if (!$booking->canBeReviewed()) {
            return redirect()->route('my-bookings')
                ->with('error', 'Vous ne pouvez pas donner d\'avis pour cette réservation.');
        }
        
        return view('reviews.create', compact('booking'));
    }

    public function store(StoreReviewRequest $request, Booking $booking)
    {
        if (!$booking->canBeReviewed()) {
            return redirect()->route('my-bookings')
                ->with('error', 'Vous ne pouvez pas donner d\'avis pour cette réservation.');
        }

        $review = clone $booking->review()->create([
            'booking_id' => $booking->id,
            'reviewer_id' => auth()->id(),
            'reviewed_id' => $booking->trip->driver_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Notifier le conducteur
        $booking->trip->driver->notifications()->create([
            'type' => 'new_review',
            'message' => "Vous avez reçu un nouvel avis de " . auth()->user()->name . " (Note: {$request->rating}/5)"
        ]);

        return redirect()->route('my-bookings')
            ->with('success', 'Merci pour votre avis !');
    }
}