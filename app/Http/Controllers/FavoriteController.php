<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Trip;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('trip')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Trip $trip)
    {
        $user = auth()->user();
        $favorite = $user->favorites()->where('trip_id', $trip->id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Trajet retiré des favoris.']);
        }

        $user->favorites()->create(['trip_id' => $trip->id]);
        return response()->json(['status' => 'added', 'message' => 'Trajet ajouté aux favoris.']);
    }
}
