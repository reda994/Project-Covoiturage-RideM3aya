<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mes Réservations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-100">
                    @if($bookings->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Aucune réservation</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Vous n'avez pas encore réservé de trajet.</p>
                            <div class="mt-6">
                                <a href="{{ route('trips.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-md text-base font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    Rechercher un trajet
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($bookings as $booking)
                                <div class="bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden relative">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['color' => 'yellow', 'label' => 'En attente', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            'confirmed' => ['color' => 'green', 'label' => 'Confirmée', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            'cancelled' => ['color' => 'red', 'label' => 'Annulée', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z']
                                        ];
                                        $config = $statusConfig[$booking->status];
                                    @endphp
                                    
                                    <div class="absolute top-0 right-0 mt-4 mr-4 flex items-center bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 dark:bg-{{ $config['color'] }}-900 dark:text-{{ $config['color'] }}-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                        </svg>
                                        {{ $config['label'] }}
                                    </div>

                                    <div class="p-6">
                                        <div class="flex items-center space-x-4 mb-4">
                                            <img src="{{ $booking->trip->driver->profile_photo_url }}" alt="Driver" class="w-12 h-12 rounded-full border-2 border-gray-200 dark:border-gray-600">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Conducteur</p>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $booking->trip->driver->name }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between mt-4">
                                            <div class="text-center w-5/12">
                                                <p class="text-lg font-bold text-gray-900 dark:text-white truncate" title="{{ $booking->trip->departure_city }}">{{ $booking->trip->departure_city }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($booking->trip->departure_datetime)->format('H:i') }}</p>
                                            </div>
                                            <div class="w-2/12 flex justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                </svg>
                                            </div>
                                            <div class="text-center w-5/12">
                                                <p class="text-lg font-bold text-gray-900 dark:text-white truncate" title="{{ $booking->trip->arrival_city }}">{{ $booking->trip->arrival_city }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <!-- On pourrait estimer l'heure d'arrivée si on avait la durée, ici on affiche juste la date -->
                                                    {{ \Carbon\Carbon::parse($booking->trip->departure_datetime)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-6 flex justify-between items-center bg-gray-50 dark:bg-gray-800 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Places</p>
                                                <p class="font-bold text-gray-900 dark:text-white">{{ $booking->seats_booked }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Prix total</p>
                                                <p class="font-bold text-green-600 dark:text-green-400 text-lg">{{ $booking->total_price }} MAD</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                                    Annuler la demande
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($booking->canBeReviewed())
                                            <a href="{{ route('reviews.create', $booking) }}" class="inline-flex items-center text-sm font-medium text-yellow-600 hover:text-yellow-700 dark:text-yellow-500 dark:hover:text-yellow-400 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                Évaluer le trajet
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
