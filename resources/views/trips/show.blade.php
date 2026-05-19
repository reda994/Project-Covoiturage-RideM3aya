@extends('layouts.app')

@section('title', 'Détail du trajet')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 mt-16">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Trip Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-10 relative">
                    <div class="absolute top-4 right-4 flex space-x-2">
                        <button onclick="toggleFavorite({{ $trip->id }})" class="p-2 bg-white/20 hover:bg-white/30 rounded-full backdrop-blur-sm transition" title="Ajouter aux favoris">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                        <a href="{{ route('trips.pdf', $trip) }}" class="p-2 bg-white/20 hover:bg-white/30 rounded-full backdrop-blur-sm transition" title="Télécharger le PDF">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-4 text-3xl font-extrabold mb-2">
                        <span>{{ $trip->departure_city }}</span>
                        <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        <span>{{ $trip->arrival_city }}</span>
                    </div>
                    <p class="text-lg text-green-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $trip->departure_datetime->format('l d F Y à H:i') }}
                    </p>
                </div>
                
                <div class="p-8">
                    <div class="flex items-center mb-8 pb-8 border-b dark:border-gray-700">
                        <img src="{{ $trip->driver->profile_photo_url }}" class="w-20 h-20 rounded-full mr-6 border-4 border-gray-50 dark:border-gray-700">
                        <div>
                            <h3 class="font-bold text-2xl text-gray-900 dark:text-white">{{ $trip->driver->name }}</h3>
                            <p class="text-gray-500 dark:text-gray-400">Conducteur depuis {{ $trip->driver->created_at->format('Y') }}</p>
                            @auth
                                @if(auth()->id() !== $trip->driver_id)
                                    <button onclick="document.getElementById('message-modal').classList.remove('hidden')" class="mt-2 text-sm text-green-600 dark:text-green-400 hover:underline flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                        Contacter le conducteur
                                    </button>
                                @endif
                            @endauth
                        </div>
                        <div class="ml-auto text-right">
                            <p class="text-4xl font-black text-green-600">{{ number_format($trip->price_per_seat, 2) }} <span class="text-2xl">DH</span></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">par place</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl">
                            <h4 class="font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                Véhicule
                            </h4>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $trip->vehicle->brand }} {{ $trip->vehicle->model }}</p>
                            <p class="text-gray-500 dark:text-gray-400 mt-1">Couleur: {{ $trip->vehicle->color }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl">
                            <h4 class="font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Informations
                            </h4>
                            <p class="font-medium text-green-600 dark:text-green-400 mb-1">✅ {{ $trip->available_seats }} places disponibles</p>
                            <p class="text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $trip->driver->phone ?? 'Non renseigné' }}
                            </p>
                        </div>
                    </div>

                    @if($trip->description)
                        <div class="mb-8 p-6 bg-green-50 dark:bg-green-900/20 rounded-2xl border border-green-100 dark:border-green-900/50">
                            <h4 class="font-bold mb-2 text-gray-900 dark:text-white">Mot du conducteur</h4>
                            <p class="text-gray-700 dark:text-gray-300 italic">"{{ $trip->description }}"</p>
                        </div>
                    @endif
                    
                    @auth
                        @if(auth()->id() !== $trip->driver_id && $trip->status === 'active' && $trip->available_seats > 0)
                            <div class="border-t dark:border-gray-700 pt-8 mt-8">
                                <form action="{{ route('trips.book', $trip) }}" method="POST">
                                    @csrf
                                    <div class="flex flex-col sm:flex-row items-end gap-4">
                                        <div class="w-full sm:w-auto flex-grow">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Combien de places souhaitez-vous réserver ?</label>
                                            <select name="seats_booked" class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 py-3 px-4 focus:ring-green-500 focus:border-green-500">
                                                @for($i = 1; $i <= min(4, $trip->available_seats); $i++)
                                                    <option value="{{ $i }}">{{ $i }} place(s) - {{ number_format($trip->price_per_seat * $i, 2) }} DH</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <button type="submit" class="w-full sm:w-auto bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-600/30">
                                            Réserver maintenant
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif($trip->status !== 'active' || $trip->available_seats == 0)
                            <div class="bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 p-4 rounded-xl text-center font-medium">
                                Ce trajet est complet ou n'est plus disponible.
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl text-center border border-gray-200 dark:border-gray-700 mt-8">
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Vous devez être connecté pour réserver ce trajet.</p>
                            <a href="{{ route('login') }}" class="inline-block bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-2 rounded-xl font-medium transition">
                                Se connecter
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Sidebar / Map -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 sticky top-24">
                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700 font-bold text-center text-gray-900 dark:text-white">
                    Itinéraire
                </div>
                <div id="map" class="h-[400px] w-full"></div>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div id="message-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('message-modal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700">
            <form action="{{ route('messages.store', $trip) }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-xl leading-6 font-bold text-gray-900 dark:text-white mb-4" id="modal-title">
                        Message à {{ $trip->driver->name }}
                    </h3>
                    <div class="mt-2">
                        <textarea name="content" rows="4" class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 p-3 focus:ring-green-500 focus:border-green-500" placeholder="Bonjour, je suis intéressé par votre trajet..."></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 dark:border-gray-700">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Envoyer
                    </button>
                    <button type="button" onclick="document.getElementById('message-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init Map
        var map = L.map('map').setView([{{ $trip->start_lat ?? 33.5731 }}, {{ $trip->start_lng ?? -7.5898 }}], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        @if($trip->start_lat && $trip->start_lng && $trip->end_lat && $trip->end_lng)
            var start = [{{ $trip->start_lat }}, {{ $trip->start_lng }}];
            var end = [{{ $trip->end_lat }}, {{ $trip->end_lng }}];
            
            var startMarker = L.marker(start).addTo(map).bindPopup("<b>Départ:</b> {{ $trip->departure_city }}");
            var endMarker = L.marker(end).addTo(map).bindPopup("<b>Arrivée:</b> {{ $trip->arrival_city }}");
            
            var latlngs = [start, end];
            var polyline = L.polyline(latlngs, {color: '#16a34a', weight: 4, dashArray: '10, 10'}).addTo(map);
            
            map.fitBounds(polyline.getBounds(), {padding: [50, 50]});
        @else
            // Fallback marker if exact coordinates are missing
            L.marker([33.5731, -7.5898]).addTo(map).bindPopup("{{ $trip->departure_city }} (Approximatif)");
        @endif
    });

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
            alert(data.message);
        });
    }
</script>
@endsection