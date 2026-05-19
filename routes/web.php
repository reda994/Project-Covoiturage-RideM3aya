<?php
// routes/web.php

use App\Http\Controllers\{
    TripController, BookingController, DriverController,
    VehicleController, ReviewController, ProfileController,
    NotificationController, MessageController, FavoriteController
};
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    UserController as AdminUserController,
    TripController as AdminTripController
};

Route::get('/', [TripController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // Dashboard Général
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    
    // Messages & Favoris
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/trips/{trip}/message', [MessageController::class, 'store'])->name('messages.store');
    
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/trips/{trip}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
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
    Route::get('/trips/{trip}/pdf', [TripController::class, 'exportPdf'])->name('trips.pdf');
    
    // Admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/trips', [AdminTripController::class, 'index'])->name('trips.index');
        Route::get('/trips/{trip}', [AdminTripController::class, 'show'])->name('trips.show');
        Route::delete('/trips/{trip}', [AdminTripController::class, 'destroy'])->name('trips.destroy');
        Route::get('/reviews', [AdminTripController::class, 'reviews'])->name('reviews.index');
        Route::delete('/reviews/{review}', [AdminTripController::class, 'deleteReview'])->name('reviews.destroy');
    });
});

require __DIR__.'/auth.php';