@extends('layouts.app')

@section('title', 'Rechercher un trajet')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Rechercher un trajet</h2>
        
        <form action="{{ route('trips.index') }}" method="GET" class="grid md:grid-cols-5 gap-4">
            <input type="text" name="departure_city" placeholder="Départ" value="{{ request('departure_city') }}" class="rounded-lg border-gray-300">
            <input type="text" name="arrival_city" placeholder="Arrivée" value="{{ request('arrival_city') }}" class="rounded-lg border-gray-300">
            <input type="date" name="date" value="{{ request('date') }}" class="rounded-lg border-gray-300">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                Rechercher
            </button>
        </form>
    </div>
    
    <div class="space-y-4">
        @forelse($trips as $trip)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-4">
                            <img src="{{ $trip->driver->profile_photo_url }}" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h3 class="font-semibold">{{ $trip->driver->name }}</h3>
                                <div class="flex items-center text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= round($trip->driver->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-center">
                                <p class="font-bold text-lg">{{ $trip->departure_city }}</p>
                                <p class="text-sm text-gray-600">{{ $trip->departure_datetime->format('H:i') }}</p>
                            </div>
                            <div class="flex-1 mx-4">
                                <div class="border-t-2 border-gray-300"></div>
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-lg">{{ $trip->arrival_city }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-2xl font-bold text-green-600">{{ number_format($trip->price_per_seat, 2) }} DH</p>
                        <p class="text-sm text-gray-600 mb-2">par place</p>
                        <p class="text-sm mb-3">{{ $trip->available_seats }} places</p>
                        
                        @auth
                            @if(auth()->id() !== $trip->driver_id && $trip->available_seats > 0)
                                <a href="{{ route('trips.show', $trip) }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                    Réserver
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                Connexion
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-600">Aucun trajet trouvé</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $trips->withQueryString()->links() }}
    </div>
</div>
@endsection