<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Profil Utilisateur: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                &larr; Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informations de base -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center gap-8">
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full border-4 border-gray-200 dark:border-gray-700 object-cover">
                    
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <div>
                                @if($user->role === 'admin')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                                @elseif($user->role === 'driver')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Conducteur</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Passager</span>
                                @endif
                                
                                @if($user->is_active)
                                    <span class="ml-2 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Actif</span>
                                @else
                                    <span class="ml-2 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Désactivé</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléphone</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->phone ?? 'Non renseigné' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'inscription</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Note moyenne</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ number_format($user->average_rating, 1) }} / 5 ({{ $user->reviewsReceived()->count() }} avis)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trajets proposés (si conducteur) -->
            @if($user->isDriver())
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">Trajets proposés en tant que conducteur</h3>
                    
                    @if($user->tripsAsDriver->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Aucun trajet proposé.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Départ &rarr; Arrivée</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Réservations</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($user->tripsAsDriver->sortByDesc('departure_datetime') as $trip)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($trip->departure_datetime)->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $trip->departure_city }} &rarr; {{ $trip->arrival_city }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $trip->price_per_seat }} MAD</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($trip->status) }}</span>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-right text-gray-900 dark:text-white">{{ $trip->bookings->count() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Réservations effectuées -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">Réservations en tant que passager</h3>
                    
                    @if($user->bookingsAsPassenger->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Aucune réservation effectuée.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trajet</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Places</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($user->bookingsAsPassenger->sortByDesc('created_at') as $booking)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $booking->created_at->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $booking->trip->departure_city ?? '?' }} &rarr; {{ $booking->trip->arrival_city ?? '?' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $booking->seats_booked }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($booking->status) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Avis reçus -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">Avis reçus</h3>
                    
                    @if($user->reviewsReceived->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Aucun avis reçu.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($user->reviewsReceived->sortByDesc('created_at') as $review)
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $review->reviewer->name ?? 'Utilisateur supprimé' }}</span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
