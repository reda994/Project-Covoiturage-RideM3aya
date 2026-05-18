@extends('layouts.app')

@section('title', 'Détail du trajet')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4">
            <h1 class="text-2xl font-bold">{{ $trip->departure_city }} → {{ $trip->arrival_city }}</h1>
            <p>{{ $trip->departure_datetime->format('l d F Y à H:i') }}</p>
        </div>
        
        <div class="p-6">
            <div class="flex items-center mb-6 pb-6 border-b">
                <img src="{{ $trip->driver->profile_photo_url }}" class="w-16 h-16 rounded-full mr-4">
                <div>
                    <h3 class="font-semibold text-lg">{{ $trip->driver->name }}</h3>
                    <p class="text-gray-600">Conducteur depuis {{ $trip->driver->created_at->format('Y') }}</p>
                </div>
                <div class="ml-auto text-right">
                    <p class="text-3xl font-bold text-green-600">{{ number_format($trip->price_per_seat, 2) }} DH</p>
                    <p class="text-sm text-gray-600">par place</p>
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h4 class="font-semibold mb-2">Véhicule</h4>
                    <p>{{ $trip->vehicle->brand }} {{ $trip->vehicle->model }}</p>
                    <p>Couleur: {{ $trip->vehicle->color }}</p>
                    <p>{{ $trip->vehicle->seats_total }} places</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Informations</h4>
                    <p>✅ {{ $trip->available_seats }} places disponibles</p>
                    <p>📱 {{ $trip->driver->phone ?? 'Non renseigné' }}</p>
                </div>
            </div>
            
            @auth
                @if(auth()->id() !== $trip->driver_id && $trip->status === 'active' && $trip->available_seats > 0)
                    <div class="border-t pt-6">
                        <form action="{{ route('trips.book', $trip) }}" method="POST">
                            @csrf
                            <div class="flex items-end space-x-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de places</label>
                                    <select name="seats_booked" class="rounded-lg border-gray-300">
                                        @for($i = 1; $i <= min(4, $trip->available_seats); $i++)
                                            <option value="{{ $i }}">{{ $i }} place(s) - {{ number_format($trip->price_per_seat * $i, 2) }} DH</option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                                    Réserver
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @else
                <div class="bg-gray-100 p-4 rounded-lg text-center">
                    <a href="{{ route('login') }}" class="text-green-600">Connectez-vous</a> pour réserver
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection