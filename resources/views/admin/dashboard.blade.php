<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de Bord Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Cards statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                <!-- Total Utilisateurs -->
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-blue-100 uppercase tracking-wider">Utilisateurs</p>
                            <h3 class="text-3xl font-extrabold mt-1">{{ $totalUsers }}</h3>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Conducteurs -->
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-emerald-100 uppercase tracking-wider">Conducteurs</p>
                            <h3 class="text-3xl font-extrabold mt-1">{{ $totalDrivers }}</h3>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Passagers -->
                <div class="bg-gradient-to-br from-cyan-500 to-blue-600 dark:from-cyan-600 dark:to-blue-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-cyan-100 uppercase tracking-wider">Passagers</p>
                            <h3 class="text-3xl font-extrabold mt-1">{{ $totalPassengers }}</h3>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Trajets Actifs -->
                <div class="bg-gradient-to-br from-violet-500 to-purple-600 dark:from-violet-600 dark:to-purple-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-violet-100 uppercase tracking-wider">Trajets Actifs</p>
                            <h3 class="text-3xl font-extrabold mt-1">{{ $totalTrips }}</h3>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Réservations -->
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 dark:from-amber-600 dark:to-orange-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-amber-100 uppercase tracking-wider">Réserves</p>
                            <h3 class="text-3xl font-extrabold mt-1">{{ $totalBookings }}</h3>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Avis -->
                <div class="bg-gradient-to-br from-rose-500 to-pink-600 dark:from-rose-600 dark:to-pink-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-rose-100 uppercase tracking-wider">Avis</p>
                            <h3 class="text-3xl font-extrabold mt-1">{{ $totalReviews }}</h3>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphique d'inscription & Conducteurs Actifs -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Graphique d'inscription -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Inscriptions des 6 derniers mois
                    </h3>
                    <div class="relative h-64 w-full">
                        <canvas id="registrationsChart"></canvas>
                    </div>
                </div>

                <!-- Conducteurs les plus actifs -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Conducteurs les plus actifs
                    </h3>
                    <div class="flex-1 space-y-4 overflow-y-auto">
                        @forelse($topDrivers as $driver)
                            <div class="flex items-center justify-between p-3 rounded-2xl bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $driver->profile_photo_url }}" alt="{{ $driver->name }}" class="w-10 h-10 rounded-full border object-cover">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $driver->name }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $driver->email }}</p>
                                    </div>
                                </div>
                                <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 text-xs font-bold px-2.5 py-1 rounded-full">
                                    {{ $driver->trips_as_driver_count }} trajets
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-6">Aucun conducteur enregistré.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Derniers trajets & Utilisateurs -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Derniers trajets -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 overflow-hidden">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 text-violet-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Derniers trajets publiés
                        </h3>
                        <a href="{{ route('admin.trips.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">Voir tout</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-700 text-gray-400 text-xs uppercase font-semibold">
                                    <th class="py-3 px-4">Conducteur</th>
                                    <th class="py-3 px-4">Itinéraire</th>
                                    <th class="py-3 px-4">Date</th>
                                    <th class="py-3 px-4 text-right">Prix</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                                @forelse($latestTrips as $trip)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30">
                                        <td class="py-3 px-4 flex items-center space-x-2">
                                            <img src="{{ $trip->driver->profile_photo_url }}" class="w-6 h-6 rounded-full object-cover">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $trip->driver->name }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-750 dark:text-gray-300 font-medium">
                                            {{ $trip->departure_city }} &rarr; {{ $trip->arrival_city }}
                                        </td>
                                        <td class="py-3 px-4 text-gray-500 dark:text-gray-400 text-xs">
                                            {{ \Carbon\Carbon::parse($trip->departure_datetime)->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="py-3 px-4 text-right font-bold text-green-600 dark:text-green-400">
                                            {{ $trip->price_per_seat }} MAD
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">Aucun trajet récent.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Derniers utilisateurs -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 overflow-hidden">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Nouveaux utilisateurs
                        </h3>
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">Voir tout</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-700 text-gray-400 text-xs uppercase font-semibold">
                                    <th class="py-3 px-4">Utilisateur</th>
                                    <th class="py-3 px-4">Rôle</th>
                                    <th class="py-3 px-4">Inscription</th>
                                    <th class="py-3 px-4 text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                                @forelse($latestUsers as $user)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30">
                                        <td class="py-3 px-4 flex items-center space-x-3">
                                            <img src="{{ $user->profile_photo_url }}" class="w-6 h-6 rounded-full object-cover">
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-xs font-semibold">
                                            @if($user->role === 'admin')
                                                <span class="px-2 py-0.5 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300">Admin</span>
                                            @elseif($user->role === 'driver')
                                                <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300">Conducteur</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">Passager</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-gray-500 dark:text-gray-400 text-xs">
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            @if($user->is_active)
                                                <span class="text-emerald-600 dark:text-emerald-400 font-bold text-xs">Actif</span>
                                            @else
                                                <span class="text-red-500 dark:text-red-400 font-bold text-xs">Désactivé</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">Aucun utilisateur récent.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js configuration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('registrationsChart').getContext('2d');
            
            // Format data from Laravel controller
            const rawData = @json($registrations);
            const labels = rawData.map(item => item.month);
            const dataValues = rawData.map(item => item.count);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels.length ? labels : ['Aucune donnée'],
                    datasets: [{
                        label: 'Inscriptions',
                        data: dataValues.length ? dataValues : [0],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366f1',
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)'
                            },
                            ticks: {
                                precision: 0,
                                color: '#9ca3af'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
