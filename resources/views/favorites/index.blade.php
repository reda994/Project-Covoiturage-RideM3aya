@extends('layouts.app')

@section('title', 'Mes favoris')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 mt-16">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 animate-fade-in">Mes trajets favoris</h1>
    
    @if(auth()->user()->favorites->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-12 text-center border border-gray-100 dark:border-gray-700 animate-fade-in">
            <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucun favori</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Vous n'avez pas encore ajouté de trajets à vos favoris.</p>
            <a href="{{ route('trips.index') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-medium">
                Rechercher des trajets
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(auth()->user()->favorites as $favorite)
                @php $trip = $favorite->trip @endphp
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-xl transition animate-slide-left">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-4 relative">
                        <button onclick="toggleFavorite({{ $trip->id }})" class="absolute top-4 right-4 p-2 bg-white/20 hover:bg-white/30 rounded-full backdrop-blur-sm transition">
                            <svg class="w-5 h-5 text-red-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                        <div class="flex items-center gap-2 text-lg font-bold">
                            <span>{{ $trip->departure_city }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            <span>{{ $trip->arrival_city }}</span>
                        </div>
                        <p class="text-green-100 text-sm mt-1">{{ $trip->departure_datetime->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img src="{{ $trip->driver->profile_photo_url }}" class="w-10 h-10 rounded-full mr-3 border-2 border-green-500">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $trip->driver->name }}</p>
                                <div class="flex items-center text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= round($trip->driver->average_rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-2xl font-bold text-green-600">{{ number_format($trip->price_per_seat, 2) }} DH</p>
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-medium">
                                {{ $trip->available_seats }} places
                            </span>
                        </div>
                        <a href="{{ route('trips.show', $trip) }}" class="block mt-4 text-center bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition font-medium">
                            Voir détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function toggleFavorite(tripId) {
        fetch(`/trips/${tripId}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        });
    }
</script>
@endsection
