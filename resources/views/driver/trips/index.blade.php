{{-- resources/views/driver/trips/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mes trajets - Conducteur')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Mes trajets</h1>
        <a href="{{ route('driver.trips.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            + Nouveau trajet
        </a>
    </div>
    
    <div class="space-y-4">
        @forelse($trips as $trip)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-wrap justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-4">
                            <span class="text-2xl font-bold">{{ $trip->departure_city }}</span>
                            <svg class="w-6 h-6 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                            <span class="text-2xl font-bold">{{ $trip->arrival_city }}</span>
                        </div>
                        
                        <div class="grid md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium">{{ $trip->departure_datetime->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Prix:</span>
                                <span class="font-medium">{{ number_format($trip->price_per_seat, 2) }} DH/place</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Places:</span>
                                <span class="font-medium">{{ $trip->available_seats }}/{{ $trip->vehicle->seats_total }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            @php
                                $statusColors = [
                                    'active' => 'green',
                                    'full' => 'orange',
                                    'cancelled' => 'red',
                                    'completed' => 'gray'
                                ];
                            @endphp
                            <span class="inline-block px-2 py-1 rounded text-xs bg-{{ $statusColors[$trip->status] }}-100 text-{{ $statusColors[$trip->status] }}-700">
                                {{ ucfirst($trip->status) }}
                            </span>
                            
                            @if($trip->bookings->where('status', 'pending')->count() > 0)
                                <span class="inline-block px-2 py-1 rounded text-xs bg-blue-100 text-blue-700 ml-2">
                                    {{ $trip->bookings->where('status', 'pending')->count() }} demande(s) en attente
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex space-x-2 mt-4 md:mt-0">
                        @if($trip->status === 'active' && $trip->departure_datetime > now())
                            <a href="{{ route('driver.trips.edit', $trip) }}" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('driver.trips.cancel', $trip) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Annuler ce trajet ? Les passagers seront notifiés.')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('trips.show', $trip) }}" class="text-gray-600 hover:text-gray-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-600">Vous n'avez pas encore créé de trajet.</p>
                <a href="{{ route('driver.trips.create') }}" class="inline-block mt-4 text-green-600 hover:text-green-700">
                    Créer mon premier trajet →
                </a>
            </div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $trips->links() }}
    </div>
</div>
@endsection