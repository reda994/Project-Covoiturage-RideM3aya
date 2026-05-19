<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\SearchTripRequest;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

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
        
        // Pour la page d'accueil, on prend les 6 prochains trajets avec cache
        $upcomingTrips = Cache::remember('upcoming_trips', 600, function() {
            return Trip::with(['driver', 'vehicle'])
                ->where('status', 'active')
                ->where('departure_datetime', '>', now())
                ->orderBy('departure_datetime')
                ->limit(6)
                ->get();
        });
        
        return view('trips.index', compact('trips', 'upcomingTrips'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['driver', 'vehicle', 'bookings' => function($q) {
            $q->where('status', 'confirmed');
        }]);
        
        return view('trips.show', compact('trip'));
    }

    public function exportPdf(Trip $trip)
    {
        $trip->load(['driver', 'vehicle']);
        
        $pdf = Pdf::loadView('trips.pdf', compact('trip'));
        
        return $pdf->download("trajet-{$trip->id}-{$trip->departure_city}-{$trip->arrival_city}.pdf");
    }

    public function store(StoreTripRequest $request)
    {
        $trip = Trip::create($request->validated());
        Cache::forget('upcoming_trips');
        return redirect()->route('trips.show', $trip)->with('success', 'Trajet créé avec succès !');
    }

    public function edit(Trip $trip)
    {
        $this->authorize('update', $trip);
        
        if ($trip->departure_datetime < now()) {
            return back()->with('error', 'Les trajets passés ne peuvent plus être modifiés.');
        }

        $trip->load(['driver', 'vehicle']);
        return view('driver.trips.edit', compact('trip'));
    }

    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $this->authorize('update', $trip);

        if ($trip->departure_datetime < now()) {
            return back()->with('error', 'Les trajets passés ne peuvent plus être modifiés.');
        }

        $trip->update($request->validated());
        Cache::forget('upcoming_trips');
        Cache::forget('trips_*');
        return redirect()->route('trips.show', $trip)->with('success', 'Trajet mis à jour avec succès !');
    }

    public function cancel(Trip $trip)
    {
        $this->authorize('delete', $trip);

        if ($trip->departure_datetime < now()) {
            return back()->with('error', 'Les trajets passés ne peuvent plus être annulés.');
        }

        $trip->update(['status' => 'cancelled']);
        Cache::forget('upcoming_trips');
        Cache::forget('trips_*');
        return back()->with('success', 'Trajet annulé avec succès !');
    }
}