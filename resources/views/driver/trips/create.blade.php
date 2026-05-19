<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Publier un trajet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    @if(auth()->user()->vehicles->isEmpty())
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Vous devez d'abord ajouter un véhicule avant de pouvoir publier un trajet.
                                        <a href="{{ route('driver.vehicles.create') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">Ajouter un véhicule maintenant</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('driver.trips.store') }}">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Départ -->
                                <div>
                                    <label for="departure_city" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ville de départ</label>
                                    <input id="departure_city" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="departure_city" value="{{ old('departure_city') }}" required />
                                    @error('departure_city')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Arrivée -->
                                <div>
                                    <label for="arrival_city" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ville d'arrivée</label>
                                    <input id="arrival_city" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="arrival_city" value="{{ old('arrival_city') }}" required />
                                    @error('arrival_city')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date et heure -->
                                <div>
                                    <label for="departure_datetime" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date et heure de départ</label>
                                    <input id="departure_datetime" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="datetime-local" name="departure_datetime" value="{{ old('departure_datetime') }}" required min="{{ date('Y-m-d\TH:i') }}" />
                                    @error('departure_datetime')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Prix par place -->
                                <div>
                                    <label for="price_per_seat" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Prix par place (MAD)</label>
                                    <input id="price_per_seat" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="number" step="0.01" name="price_per_seat" value="{{ old('price_per_seat') }}" required min="1" />
                                    @error('price_per_seat')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Véhicule -->
                                <div>
                                    <label for="vehicle_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Véhicule</label>
                                    <select id="vehicle_id" name="vehicle_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Sélectionnez un véhicule</option>
                                        @foreach(auth()->user()->vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" data-seats="{{ $vehicle->seats_total }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->seats_total }} places)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Places disponibles -->
                                <div>
                                    <label for="available_seats" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Places proposées</label>
                                    <input id="available_seats" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="number" name="available_seats" value="{{ old('available_seats') }}" required min="1" />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="seats_hint">Maximum: 0 places</p>
                                    @error('available_seats')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Détails du trajet (optionnel)</label>
                                    <textarea id="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" rows="3" placeholder="Lieu de rendez-vous exact, taille des bagages acceptés, etc.">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="driver_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="status" value="active">

                            <div class="flex items-center justify-end mt-8">
                                <a href="{{ route('driver.trips.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                    Annuler
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                    Publier le trajet
                                </button>
                            </div>
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const vehicleSelect = document.getElementById('vehicle_id');
                                const availableSeatsInput = document.getElementById('available_seats');
                                const seatsHint = document.getElementById('seats_hint');

                                function updateMaxSeats() {
                                    if (vehicleSelect.selectedIndex > 0) {
                                        const option = vehicleSelect.options[vehicleSelect.selectedIndex];
                                        const maxSeats = option.getAttribute('data-seats');
                                        availableSeatsInput.max = maxSeats;
                                        seatsHint.textContent = `Maximum: ${maxSeats} places`;
                                        
                                        if (parseInt(availableSeatsInput.value) > parseInt(maxSeats)) {
                                            availableSeatsInput.value = maxSeats;
                                        }
                                    } else {
                                        availableSeatsInput.max = 0;
                                        seatsHint.textContent = 'Sélectionnez un véhicule';
                                    }
                                }

                                vehicleSelect.addEventListener('change', updateMaxSeats);
                                updateMaxSeats(); // Initialiser au chargement
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
