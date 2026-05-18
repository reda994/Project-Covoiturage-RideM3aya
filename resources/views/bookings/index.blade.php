@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Mes réservations</h1>
    
    <div class="space-y-4">
        @forelse($bookings as $booking)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-lg">{{ $booking->trip->departure_city }} → {{ $booking->trip->arrival_city }}</h3>
                        <p class="text-gray-600">{{ $booking->trip->departure_datetime->format('d/m/Y H:i') }}</p>
                        <p class="text-sm mt-2">Conducteur: {{ $booking->trip->driver->name }}</p>
                        <p class="text-sm">{{ $booking->seats_booked }} place(s) - {{ number_format($booking->total_price, 2) }} DH</p>
                        
                        @php
                            $statusColors = [
                                'pending' => 'orange',
                                'confirmed' => 'green',
                                'cancelled' => 'red'
                            ];
                        @endphp
                        <span class="inline-block mt-2 px-2 py-1 rounded text-xs bg-{{ $statusColors[$booking->status] }}-100 text-{{ $statusColors[$booking->status] }}-700">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    
                    <div class="text-right">
                        @if($booking->status === 'pending')
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Annuler cette réservation ?')">
                                    Annuler
                                </button>
                            </form>
                        @endif
                        
                        @if($booking->canBeReviewed())
                            <a href="{{ route('reviews.create', $booking) }}" class="inline-block mt-2 text-green-600 hover:text-green-700">
                                Donner mon avis
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600">Vous n'avez pas encore de réservation</p>
                <a href="{{ route('trips.index') }}" class="inline-block mt-4 text-green-600">Rechercher un trajet →</a>
            </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
