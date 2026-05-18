<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Review;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with('driver')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.trips.index', compact('trips'));
    }
    
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return back()->with('success', 'Trajet supprimé.');
    }
    
    public function reviews()
    {
        $reviews = Review::with(['reviewer', 'reviewed'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }
}