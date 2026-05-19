<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Mes trajets
            </h2>
            <a href="{{ route('driver.trips.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 transition ease-in-out duration-150">
                + Nouveau trajet
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-100">
                    @if($trips->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Aucun trajet</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Vous n'avez pas encore publié de trajet.</p>
                            <div class="mt-6">
                                <a href="{{ route('driver.trips.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-md text-base font-medium rounded-full text-white bg-green-600 hover:bg-green-700 transition-colors">
                                    Créer mon premier trajet
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2">
                            @foreach($trips as $trip)
                                <div class="bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden relative">
                                    @php
                                        $statusConfig = [
                                            'active' => ['color' => 'green', 'label' => 'Actif'],
                                            'full' => ['color' => 'orange', 'label' => 'Complet'],
                                            'cancelled' => ['color' => 'red', 'label' => 'Annulé'],
                                            'completed' => ['color' => 'gray', 'label' => 'Terminé']
                                        ];
                                        $config = $statusConfig[$trip->status] ?? ['color' => 'gray', 'label' => ucfirst($trip->status)];
                                    @endphp
                                    
                                    <div class="absolute top-0 right-0 mt-4 mr-4 flex items-center bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 dark:bg-{{ $config['color'] }}-900 dark:text-{{ $config['color'] }}-200 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                        {{ $config['label'] }}
                                    </div>

                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-4 mt-2">
                                            <div class="text-center w-5/12">
                                                <p class="text-xl font-bold text-gray-900 dark:text-white truncate" title="{{ $trip->departure_city }}">{{ $trip->departure_city }}</p>
                                            </div>
                                            <div class="w-2/12 flex justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                </svg>
                                            </div>
                                            <div class="text-center w-5/12">
                                                <p class="text-xl font-bold text-gray-900 dark:text-white truncate" title="{{ $trip->arrival_city }}">{{ $trip->arrival_city }}</p>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 grid grid-cols-2 gap-4 text-sm mt-6 border border-gray-100 dark:border-gray-600">
                                            <div>
                                                <p class="text-gray-500 dark:text-gray-400">Date de départ</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $trip->departure_datetime->format('d/m/Y H:i') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 dark:text-gray-400">Prix par place</p>
                                                <p class="font-bold text-green-600 dark:text-green-400">{{ number_format($trip->price_per_seat, 2) }} DH</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 dark:text-gray-400">Places restantes</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $trip->available_seats }}/{{ $trip->vehicle->seats_total }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 dark:text-gray-400">Véhicule</p>
                                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $trip->vehicle->brand }} {{ $trip->vehicle->model }}</p>
                                            </div>
                                        </div>
                                        
                                        @if($trip->bookings->where('status', 'pending')->count() > 0)
                                            <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 rounded-lg flex items-center">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                </svg>
                                                <span class="text-sm text-blue-700 dark:text-blue-300 font-medium">
                                                    {{ $trip->bookings->where('status', 'pending')->count() }} demande(s) en attente
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-4 items-center">
                                        <a href="{{ route('trips.show', $trip) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" title="Voir les détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        @if($trip->status === 'active' && $trip->departure_datetime > now())
                                            <a href="{{ route('driver.trips.edit', $trip) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('driver.trips.cancel', $trip) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Annuler" onclick="return confirm('Annuler ce trajet ? Les passagers seront notifiés.')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            {{ $trips->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>