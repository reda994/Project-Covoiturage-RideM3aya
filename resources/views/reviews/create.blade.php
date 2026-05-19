<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Laisser un avis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center space-x-4 mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <img src="{{ $booking->trip->driver->profile_photo_url }}" alt="{{ $booking->trip->driver->name }}" class="w-16 h-16 rounded-full">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Évaluer le conducteur: {{ $booking->trip->driver->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                Pour le trajet : {{ $booking->trip->departure_city }} &rarr; {{ $booking->trip->arrival_city }}
                                ({{ \Carbon\Carbon::parse($booking->trip->departure_datetime)->format('d/m/Y') }})
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('reviews.store', $booking) }}">
                        @csrf

                        <!-- Note -->
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Note sur 5</label>
                            <div class="flex items-center space-x-2" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" data-rating="{{ $i }}" class="star-btn focus:outline-none">
                                        <svg class="w-10 h-10 text-gray-300 hover:text-yellow-400 transition-colors cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}" required>
                            @error('rating')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500" id="rating-text">Sélectionnez une note</p>
                        </div>

                        <!-- Commentaire -->
                        <div class="mb-6">
                            <label for="comment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Commentaire (optionnel mais recommandé)</label>
                            <textarea id="comment" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="comment" rows="4" placeholder="Comment s'est passé le trajet avec {{ $booking->trip->driver->name }} ?">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('my-bookings') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150" id="submit-btn" disabled>
                                Publier l'avis
                            </button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const stars = document.querySelectorAll('.star-btn');
                            const ratingInput = document.getElementById('rating-input');
                            const ratingText = document.getElementById('rating-text');
                            const submitBtn = document.getElementById('submit-btn');
                            
                            const texts = [
                                'À fuir',
                                'Décevant',
                                'Correct',
                                'Très bien',
                                'Parfait !'
                            ];

                            function updateStars(rating) {
                                stars.forEach((star, index) => {
                                    const svg = star.querySelector('svg');
                                    if (index < rating) {
                                        svg.classList.remove('text-gray-300');
                                        svg.classList.add('text-yellow-400');
                                    } else {
                                        svg.classList.remove('text-yellow-400');
                                        svg.classList.add('text-gray-300');
                                    }
                                });
                                
                                if (rating > 0) {
                                    ratingText.textContent = texts[rating - 1];
                                    ratingText.classList.remove('text-gray-500');
                                    ratingText.classList.add('text-yellow-600', 'dark:text-yellow-400', 'font-medium');
                                    submitBtn.disabled = false;
                                }
                            }

                            stars.forEach(star => {
                                star.addEventListener('mouseover', function() {
                                    const rating = this.getAttribute('data-rating');
                                    updateStars(rating);
                                });

                                star.addEventListener('click', function() {
                                    const rating = this.getAttribute('data-rating');
                                    ratingInput.value = rating;
                                    updateStars(rating);
                                });
                            });

                            document.getElementById('star-rating').addEventListener('mouseleave', function() {
                                updateStars(ratingInput.value || 0);
                            });
                            
                            // Init si une valeur existe (old input)
                            if (ratingInput.value) {
                                updateStars(ratingInput.value);
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
