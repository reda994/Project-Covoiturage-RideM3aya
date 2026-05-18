<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trip;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalDrivers = User::where('role', 'driver')->count();
        $totalTrips = Trip::count();
        $totalBookings = Booking::count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalDrivers', 'totalTrips', 'totalBookings'));
    }
}