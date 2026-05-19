<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Détail du Trajet #{{ $trip->id }}
            </h2>
            <a href="{{ route('admin.trips.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                &larr; Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informations du Trajet -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300">
                                {{ ucfirst($trip->status) }}
                            </span>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                                {{ $trip->departure_city }} &rarr; {{ $trip->arrival_city }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider block">Prix par place</span>
                            <span class="text-2xl font-extrabold text-green-600 dark:text-green-400">{{ $trip->price_per_seat }} MAD</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-gray-100 dark:border-gray-700 pt-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date et heure de départ</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ \Carbon\Carbon::parse($trip->departure_datetime)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Places Disponibles</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $trip->available_seats }} places restantes
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Véhicule Utilisé</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $trip->vehicle->brand ?? 'Inconnu' }} {{ $trip->vehicle->model ?? '' }} ({{ $trip->vehicle->plate_number ?? '' }})
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conducteur -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Conducteur</h3>
                <div class="flex items-center space-x-4">
                    <img src="{{ $trip->driver->profile_photo_url }}" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <a href="{{ route('admin.users.show', $trip->driver) }}" class="font-bold text-gray-900 dark:text-white hover:underline">
                            {{ $trip->driver->name }}
                        </a>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $trip->driver->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Passagers / Réservations -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">Passagers inscrits</h3>
                
                @if($trip->bookings->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Aucune réservation sur ce trajet pour le moment.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="text-gray-500 text-xs uppercase font-semibold">
                                    <th class="px-4 py-2 text-left">Passager</th>
                                    <th class="px-4 py-2 text-left">Places réservées</th>
                                    <th class="px-4 py-2 text-left">Prix total</th>
                                    <th class="px-4 py-2 text-left">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($trip->bookings as $booking)
                                    <tr>
                                        <td class="px-4 py-2 flex items-center space-x-2">
                                            <img src="{{ $booking->passenger->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <a href="{{ route('admin.users.show', $booking->passenger) }}" class="font-medium text-gray-900 dark:text-white hover:underline">
                                                    {{ $booking->passenger->name }}
                                                </a>
                                                <p class="text-xs text-gray-400">{{ $booking->passenger->email }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $booking->seats_booked }}</td>
                                        <td class="px-4 py-2 text-sm font-bold text-gray-900 dark:text-white">{{ $booking->total_price }} MAD</td>
                                        <td class="px-4 py-2 text-sm">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Actions de Modération -->
            <div class="bg-red-50 dark:bg-red-950/20 shadow sm:rounded-lg border border-red-200 dark:border-red-900/50 p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-red-800 dark:text-red-300">Zone de danger</h3>
                    <p class="text-sm text-red-600 dark:text-red-400">En tant qu'administrateur, vous pouvez supprimer ce trajet s'il contrevient aux règles.</p>
                </div>
                <form method="POST" action="{{ route('admin.trips.destroy', $trip) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-750 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce trajet ? Cette action est irréversible.')">
                        Supprimer le trajet
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
