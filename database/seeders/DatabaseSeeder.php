<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'admin
        $admin = User::factory()->admin()->create();
        
        // Créer 4 conducteurs
        $drivers = User::factory(4)->driver()->create();
        
        // Créer 5 passagers
        $passengers = User::factory(5)->create();
        
        // Tous les utilisateurs (pour les véhicules et trajets)
        $allDrivers = User::where('role', 'driver')->get();
        
        // Créer des véhicules pour chaque conducteur
        foreach ($allDrivers as $driver) {
            Vehicle::factory(rand(1, 2))->create(['user_id' => $driver->id]);
        }
        
        // Créer des trajets
        $trips = [];
        foreach ($allDrivers as $driver) {
            $vehicle = $driver->vehicles->random();
            $trips = array_merge($trips, Trip::factory(rand(3, 5))->create([
                'driver_id' => $driver->id,
                'vehicle_id' => $vehicle->id,
            ])->toArray());
        }
        
        // Créer des réservations
        $allTrips = Trip::all();
        $allPassengers = User::where('role', 'passenger')->get();
        
        foreach ($allTrips as $trip) {
            $numBookings = rand(0, 3);
            $bookedSeats = 0;
            
            for ($i = 0; $i < $numBookings; $i++) {
                if ($bookedSeats >= $trip->available_seats) break;
                
                $passenger = $allPassengers->random();
                $seatsToBook = rand(1, min(2, $trip->available_seats - $bookedSeats));
                $status = fake()->randomElement(['pending', 'confirmed', 'cancelled']);
                
                $booking = Booking::create([
                    'trip_id' => $trip->id,
                    'passenger_id' => $passenger->id,
                    'seats_booked' => $seatsToBook,
                    'total_price' => $seatsToBook * $trip->price_per_seat,
                    'status' => $status,
                ]);
                
                if ($status === 'confirmed') {
                    $bookedSeats += $seatsToBook;
                    
                    // Créer des avis pour les trajets complétés
                    if ($trip->departure_datetime < now() && rand(0, 1)) {
                        Review::create([
                            'booking_id' => $booking->id,
                            'reviewer_id' => $passenger->id,
                            'reviewed_id' => $trip->driver_id,
                            'rating' => rand(3, 5),
                            'comment' => fake()->optional(0.8)->sentence(),
                        ]);
                    }
                }
            }
            
            // Mettre à jour le statut du trajet
            if ($bookedSeats >= $trip->available_seats) {
                $trip->update(['status' => 'full']);
            }
        }
        
        // Créer des notifications
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            if (rand(0, 1)) {
                $user->notifications()->create([
                    'type' => 'welcome',
                    'message' => 'Bienvenue sur RideM3aya ! Commencez à covoiturer dès maintenant.',
                ]);
            }
        }
        
        $this->command->info('Base de données initialisée avec succès !');
        $this->command->info('Email admin: admin@ridem3aya.com');
        $this->command->info('Mot de passe: password');
    }
}