// routes/web.php
<?php

use App\Http\Controllers\{
    TripController, BookingController, DriverController,
    VehicleController, ReviewController, ProfileController,
    NotificationController
};
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    UserController as AdminUserController,
    TripController as AdminTripController
};

Route::get('/', [TripController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    
    // Réservations passager
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Avis
    Route::get('/bookings/{booking}/review/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Conducteur
    Route::prefix('driver')->name('driver.')->middleware('role:driver')->group(function () {
        // Véhicules
        Route::resource('vehicles', VehicleController::class);
        
        // Trajets
        Route::get('/trips', [DriverController::class, 'trips'])->name('trips.index');
        Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
        Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
        Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
        Route::put('/trips/{trip}', [TripController::class, 'update'])->name('trips.update');
        Route::post('/trips/{trip}/cancel', [TripController::class, 'cancel'])->name('trips.cancel');
        
        // Réservations reçues
        Route::get('/bookings', [DriverController::class, 'bookings'])->name('bookings');
        Route::post('/bookings/{booking}/confirm', [DriverController::class, 'confirmBooking'])->name('bookings.confirm');
        Route::post('/bookings/{booking}/reject', [DriverController::class, 'rejectBooking'])->name('bookings.reject');
    });
    
    // Trajets (public mais connecté)
    Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
    Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');
    Route::post('/trips/{trip}/book', [BookingController::class, 'store'])->name('trips.book');
    
    // Admin
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::get('/trips', [AdminTripController::class, 'index'])->name('trips.index');
        Route::delete('/trips/{trip}', [AdminTripController::class, 'destroy'])->name('trips.destroy');
        Route::get('/reviews', [AdminTripController::class, 'reviews'])->name('reviews.index');
    });
});

require __DIR__.'/auth.php';