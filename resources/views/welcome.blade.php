<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RideM3aya - Covoiturage au Maroc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center gap-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-500 bg-clip-text text-transparent">RideM3aya</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                        </svg>
                    </button>
                    @auth
                        <a href="{{ url('/trips') }}" class="text-sm font-medium hover:text-green-600 transition">Trajets</a>
                        <a href="{{ url('/trips') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full text-sm font-medium transition shadow-lg shadow-green-600/30">Mon Espace</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-green-600 transition">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full text-sm font-medium transition shadow-lg shadow-green-600/30">Inscription</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-morocco-pattern bg-cover bg-center opacity-20 dark:opacity-10 animate-fade-in"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-50 dark:from-gray-900 to-transparent"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-slide-in">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-6">
                Voyagez ensemble à travers <span class="bg-gradient-to-r from-red-600 to-green-600 bg-clip-text text-transparent">le Maroc</span>
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-10">
                Économisez de l'argent, rencontrez de nouvelles personnes et réduisez votre empreinte carbone avec le meilleur réseau de covoiturage.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ url('/trips') }}" class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-full text-lg font-bold transition shadow-xl shadow-green-600/40 hover:-translate-y-1">
                    Trouver un trajet
                </a>
                <a href="{{ route('driver.trips.create') }}" class="px-8 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded-full text-lg font-bold transition shadow-xl border border-gray-200 dark:border-gray-700 hover:-translate-y-1">
                    Proposer un trajet
                </a>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <form action="{{ route('trips.index') }}" method="GET" class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-2xl shadow-green-900/10 dark:shadow-black/50 border border-gray-100 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Départ</label>
                    <input type="text" name="departure_city" placeholder="Ex: Casablanca" class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Arrivée</label>
                    <input type="text" name="arrival_city" placeholder="Ex: Marrakech" class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" name="date" class="w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 focus:ring-green-500 focus:border-green-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full h-[42px] bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition shadow-lg shadow-green-600/30 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Features -->
    <div class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center p-6 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-300">
                    <div class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-6 text-green-600 dark:text-green-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Voyagez à petit prix</h3>
                    <p class="text-gray-600 dark:text-gray-400">Des trajets économiques partout au Maroc. Partagez les frais et voyagez moins cher.</p>
                </div>
                <div class="text-center p-6 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-300">
                    <div class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-6 text-green-600 dark:text-green-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">En toute confiance</h3>
                    <p class="text-gray-600 dark:text-gray-400">Profils vérifiés et avis authentiques. Voyagez l'esprit tranquille avec notre communauté.</p>
                </div>
                <div class="text-center p-6 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-300">
                    <div class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-6 text-green-600 dark:text-green-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Rapide et direct</h3>
                    <p class="text-gray-600 dark:text-gray-400">Pas de changements interminables. Arrivez plus vite à votre destination sans détours.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Dark Mode Toggle -->
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.theme === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            }
        });
    </script>
</body>
</html>
