<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Mes Véhicules
            </h2>
            <a href="{{ route('driver.vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Ajouter un véhicule
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-100">
                    @if($vehicles->isEmpty())
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Aucun véhicule</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Vous n'avez pas encore ajouté de véhicule.</p>
                            <div class="mt-6">
                                <a href="{{ route('driver.vehicles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Ajouter un véhicule
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($vehicles as $vehicle)
                                <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div class="p-5">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Immatriculation: {{ $vehicle->plate_number }}</p>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ $vehicle->seats_total }} places
                                            </span>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                <span class="font-semibold">Couleur:</span> {{ $vehicle->color }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-800 px-5 py-3 border-t border-gray-200 dark:border-gray-600 rounded-b-lg flex justify-between items-center">
                                        <a href="{{ route('driver.vehicles.edit', $vehicle) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm transition-colors">
                                            Modifier
                                        </a>
                                        <form action="{{ route('driver.vehicles.destroy', $vehicle) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm transition-colors">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
