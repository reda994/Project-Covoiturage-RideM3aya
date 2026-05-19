<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques de base
        $totalUsers = User::count();
        $totalDrivers = User::where('role', 'driver')->count();
        $totalPassengers = User::where('role', 'passenger')->orWhereNull('role')->count();
        $totalTrips = Trip::where('status', 'active')->count();
        $totalBookings = Booking::count();
        $totalReviews = Review::count();

        // Graphique des inscriptions par mois (6 derniers mois)
        $registrations = User::select(
            DB::raw('count(id) as count'), 
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month") // Note: Utilisation de DATE_FORMAT pour MySQL. Pour SQLite: strftime('%Y-%m', created_at)
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Top 5 des conducteurs les plus actifs
        $topDrivers = User::where('role', 'driver')
            ->withCount('tripsAsDriver')
            ->orderByDesc('trips_as_driver_count')
            ->take(5)
            ->get();

        // Derniers trajets
        $latestTrips = Trip::with('driver')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Derniers utilisateurs
        $latestUsers = User::orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalDrivers', 'totalPassengers', 
            'totalTrips', 'totalBookings', 'totalReviews',
            'registrations', 'topDrivers', 'latestTrips', 'latestUsers'
        ));
    }
}