
<nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-green-600 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Ride<span class="text-green-600">M3aya</span></span>
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('trips.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">Rechercher</a>
                
                @auth
                    @if(auth()->user()->isDriver())
                        <a href="{{ route('driver.trips.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">Mes trajets</a>
                        <a href="{{ route('driver.vehicles.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">Véhicules</a>
                    @endif
                    
                    <a href="{{ route('my-bookings') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">
                        Mes réservations
                    </a>
                    
                    <a href="{{ route('favorites.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">
                        Favoris
                    </a>
                    
                    <a href="{{ route('messages.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">
                        Messages
                    </a>
                    
                    <a href="{{ route('notifications.index') }}" class="relative">
                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @php
                            $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    
                    <div x-data="darkMode" x-init="init()" class="relative">
                        <button @click="toggle()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <svg x-show="!isDark" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="isDark" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="relative">
                        <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="flex items-center space-x-2">
                            <img src="{{ auth()->user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover border-2 border-green-500">
                            <span class="text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-20 hidden border border-gray-200 dark:border-gray-700">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Mon profil</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Admin Dashboard</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div x-data="darkMode" x-init="init()" class="relative">
                        <button @click="toggle()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <svg x-show="!isDark" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="isDark" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-lg shadow-green-600/30">Inscription</a>
                @endauth
            </div>
            
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('trips.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Rechercher</a>
            @auth
                @if(auth()->user()->isDriver())
                    <a href="{{ route('driver.trips.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Mes trajets</a>
                    <a href="{{ route('driver.vehicles.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Véhicules</a>
                @endif
                <a href="{{ route('my-bookings') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Mes réservations</a>
                <a href="{{ route('favorites.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Favoris</a>
                <a href="{{ route('messages.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Messages</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Mon profil</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-red-600">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">Connexion</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-green-600">Inscription</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        var menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    });
</script>