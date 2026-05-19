<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Review;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with(['driver', 'vehicle'])->withCount('bookings');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('departure_datetime', $request->date);
        }

        if ($request->filled('departure_city')) {
            $query->where('departure_city', 'like', '%' . $request->departure_city . '%');
        }

        if ($request->filled('arrival_city')) {
            $query->where('arrival_city', 'like', '%' . $request->arrival_city . '%');
        }

        $trips = $query->orderBy('departure_datetime', 'desc')->paginate(15);
        return view('admin.trips.index', compact('trips'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['driver', 'vehicle', 'bookings.passenger']);
        return view('admin.trips.show', compact('trip')); // Note: we'll create a basic show view or redirect to public show
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('admin.trips.index')->with('success', 'Trajet supprimé avec succès.');
    }

    public function reviews(Request $request)
    {
        $query = Review::with(['reviewer', 'reviewed', 'booking.trip']);

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('driver_id')) {
            $query->where('reviewed_id', $request->driver_id);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Avis supprimé avec succès.');
    }
}