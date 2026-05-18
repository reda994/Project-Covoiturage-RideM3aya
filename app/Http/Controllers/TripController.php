<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\SearchTripRequest;

class TripController extends Controller
{
    public function index(SearchTripRequest $request)
    {
        $query = Trip::with(['driver', 'vehicle'])
            ->where('status', 'active')
            ->where('departure_datetime', '>', now());

        if ($request->filled('departure_city')) {
            $query->where('departure_city', 'like', '%' . $request->departure_city . '%');
        }

        if ($request->filled('arrival_city')) {
            $query->where('arrival_city', 'like', '%' . $request->arrival_city . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('departure_datetime', $request->date);
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_seat', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_seat', '<=', $request->max_price);
        }

        if ($request->filled('seats')) {
            $query->where('available_seats', '>=', $request->seats);
        }

        $trips = $query->orderBy('departure_datetime')->paginate(12);
        
        // Pour la page d'accueil, on prend les 6 prochains trajets
        $upcomingTrips = Trip::with(['driver', 'vehicle'])
            ->where('status', 'active')
            ->where('departure_datetime', '>', now())
            ->orderBy('departure_datetime')
            ->limit(6)
            ->get();
        
        return view('trips.index', compact('trips', 'upcomingTrips'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['driver', 'vehicle', 'bookings' => function($q) {
            $q->where('status', 'confirmed');
        }]);
        
        return view('trips.show', compact('trip'));
    }
}