<footer class="bg-gray-800 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-bold text-lg mb-4">RideM3aya</h3>
                <p class="text-gray-400">Covoiturage simple, économique et écologique au Maroc.</p>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-4">Liens utiles</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('trips.index') }}" class="text-gray-400 hover:text-white">Rechercher un trajet</a></li>
                    @auth
                        <li><a href="{{ route('my-bookings') }}" class="text-gray-400 hover:text-white">Mes réservations</a></li>
                        @if(auth()->user()->isDriver())
                            <li><a href="{{ route('driver.trips.index') }}" class="text-gray-400 hover:text-white">Proposer un trajet</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-4">Contact</h3>
                <p class="text-gray-400">Email: contact@ridem3aya.com</p>
                <p class="text-gray-400">Tél: +212 5XX XXX XXX</p>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} RideM3aya. Tous droits réservés.</p>
        </div>
    </div>
</footer>
