@extends('layouts.app')

@section('title', 'Rechercher un trajet')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8 mt-16">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 mb-8 border border-gray-100 dark:border-gray-700 animate-fade-in">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Rechercher un trajet</h2>
            <div x-data="geolocation" @location-found="if($event.detail.lat) { map.setView([$event.detail.lat, $event.detail.lng], 8); }">
                <button @click="getCurrentPosition" class="flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-xl hover:bg-green-200 dark:hover:bg-green-900/50 transition">
                    <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <svg x-show="loading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="loading ? 'Localisation...' : 'Ma position'"></span>
                </button>
                <p x-show="error" class="text-red-500 text-sm mt-2" x-text="error"></p>
            </div>
        </div>
        
        <form action="{{ route('trips.index') }}" method="GET" class="grid md:grid-cols-5 gap-4">
            <div x-data="cityAutocomplete" class="relative">
                <input type="text" name="departure_city" x-model="query" @input="fetchSuggestions" placeholder="Départ" value="{{ request('departure_city') }}" class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-green-500 focus:border-green-500 px-4 py-3">
                <div x-show="showSuggestions" class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 max-h-60 overflow-y-auto">
                    <template x-for="city in suggestions" :key="city">
                        <div @click="selectCity(city)" class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-900 dark:text-white" x-text="city"></div>
                    </template>
                </div>
            </div>
            <div x-data="cityAutocomplete" class="relative">
                <input type="text" name="arrival_city" x-model="query" @input="fetchSuggestions" placeholder="Arrivée" value="{{ request('arrival_city') }}" class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-green-500 focus:border-green-500 px-4 py-3">
                <div x-show="showSuggestions" class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 max-h-60 overflow-y-auto">
                    <template x-for="city in suggestions" :key="city">
                        <div @click="selectCity(city)" class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-900 dark:text-white" x-text="city"></div>
                    </template>
                </div>
            </div>
            <input type="date" name="date" value="{{ request('date') }}" class="rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-green-500 focus:border-green-500 px-4 py-3">
            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-600/30 font-medium animate-pulse-glow">
                Rechercher
            </button>
        </form>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- List of trips -->
        <div class="w-full lg:w-1/2 space-y-4">
            @forelse($trips as $trip)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 hover:shadow-xl transition border border-gray-100 dark:border-gray-700 trip-card" 
                     data-lat="{{ $trip->start_lat ?? 33.5731 }}" 
                     data-lng="{{ $trip->start_lng ?? -7.5898 }}" 
                     data-title="{{ $trip->departure_city }} à {{ $trip->arrival_city }}"
                     data-price="{{ $trip->price_per_seat }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                <img src="{{ $trip->driver->profile_photo_url }}" class="w-12 h-12 rounded-full mr-4 border-2 border-green-500">
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $trip->driver->name }}</h3>
                                    <div class="flex items-center text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($trip->driver->average_rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-center">
                                    <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $trip->departure_city }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $trip->departure_datetime->format('H:i') }}</p>
                                </div>
                                <div class="flex-1 mx-4">
                                    <div class="border-t-2 border-dashed border-gray-300 dark:border-gray-600 relative">
                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-gray-800 px-2 text-green-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="font-bold text-lg text-gray-900 dark:text-white">{{ $trip->arrival_city }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right pl-4">
                            <p class="text-2xl font-bold text-green-600">{{ number_format($trip->price_per_seat, 2) }} DH</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">par place</p>
                            <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-medium mb-3">
                                {{ $trip->available_seats }} places
                            </span>
                            
                            @auth
                                <a href="{{ route('trips.show', $trip) }}" class="block text-center bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition w-full shadow-md">
                                    Détails
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-xl hover:bg-gray-300 transition w-full">
                                    Connexion
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-12 text-center border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">Aucun trajet trouvé</p>
                    <p class="text-gray-500 dark:text-gray-400">Essayez de modifier vos critères de recherche.</p>
                </div>
            @endforelse
            
            <div class="mt-8">
                {{ $trips->withQueryString()->links() }}
            </div>
        </div>

        <!-- Map -->
        <div class="w-full lg:w-1/2 h-[600px] rounded-3xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-24 z-10">
            <div id="map" class="w-full h-full"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Map (Center on Morocco)
        window.map = L.map('map').setView([31.7917, -7.0926], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(window.map);

        // Add markers for trips
        var bounds = [];
        document.querySelectorAll('.trip-card').forEach(function(card) {
            var lat = parseFloat(card.getAttribute('data-lat'));
            var lng = parseFloat(card.getAttribute('data-lng'));
            var title = card.getAttribute('data-title');
            var price = card.getAttribute('data-price');
            
            if(!isNaN(lat) && !isNaN(lng)) {
                var marker = L.marker([lat, lng]).addTo(window.map);
                marker.bindPopup(`<b>${title}</b><br>${price} DH par place`);
                bounds.push([lat, lng]);
            }
        });

        if(bounds.length > 0) {
            window.map.fitBounds(bounds);
        }
    });
</script>
@endsection