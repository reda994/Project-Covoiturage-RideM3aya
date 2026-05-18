{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'RideM3aya - Covoiturage au Maroc')

@section('content')
<div class="relative bg-gradient-to-r from-green-600 to-green-700 text-white">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Trajet en commun,<br>économie et écologie</h1>
        <p class="text-xl mb-8">Rejoignez des milliers de Marocains qui partagent leurs trajets chaque jour</p>
        
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-xl p-6">
            <form action="{{ route('trips.index') }}" method="GET" class="grid md:grid-cols-4 gap-4">
                <input type="text" name="departure_city" placeholder="Départ" class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                <input type="text" name="arrival_city" placeholder="Arrivée" class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                <input type="date" name="date" class="rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    Rechercher
                </button>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-center mb-12">Prochains départs</h2>
    
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($upcomingTrips ?? [] as $trip)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg">{{ $trip->departure_city }} → {{ $trip->arrival_city }}</h3>
                            <p class="text-gray-600 text-sm">{{ $trip->departure_datetime->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">{{ $trip->available_seats }} places</span>
                    </div>
                    
                    <div class="flex items-center mb-4">
                        <img src="{{ $trip->driver->profile_photo_url }}" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium">{{ $trip->driver->name }}</p>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $trip->driver->average_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-600 ml-1">({{ $trip->driver->reviewsReceived->count() }})</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <p class="text-2xl font-bold text-green-600">{{ number_format($trip->price_per_seat, 2) }} DH</p>
                        <a href="{{ route('trips.show', $trip) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            Voir
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection