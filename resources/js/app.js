import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Alpine.js Data for Auto-completion
Alpine.data('cityAutocomplete', () => ({
    query: '',
    suggestions: [],
    showSuggestions: false,
    
    moroccanCities: [
        'Casablanca', 'Rabat', 'Fès', 'Marrakech', 'Tanger', 'Agadir', 'Meknès',
        'Oujda', 'Kenitra', 'Tétouan', 'Safi', 'El Jadida', 'Beni Mellal', 'Nador',
        'Taza', 'Essaouira', 'Chefchaouen', 'Azrou', 'Ifrane', 'Al Hoceïma',
        'Khouribga', 'Settat', 'Mohammedia', 'Béni Mellal', 'Taroudant'
    ],
    
    fetchSuggestions() {
        if (this.query.length < 2) {
            this.suggestions = [];
            this.showSuggestions = false;
            return;
        }
        
        this.suggestions = this.moroccanCities.filter(city =>
            city.toLowerCase().includes(this.query.toLowerCase())
        );
        this.showSuggestions = this.suggestions.length > 0;
    },
    
    selectCity(city) {
        this.query = city;
        this.showSuggestions = false;
    }
}));

// Alpine.js Data for Dark Mode Toggle
Alpine.data('darkMode', () => ({
    isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    
    toggle() {
        this.isDark = !this.isDark;
        if (this.isDark) {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        }
    },
    
    init() {
        if (this.isDark) {
            document.documentElement.classList.add('dark');
        }
    }
}));

// Alpine.js Data for Geolocation
Alpine.data('geolocation', () => ({
    userLocation: null,
    loading: false,
    error: null,
    
    async getCurrentPosition() {
        this.loading = true;
        this.error = null;
        
        if (!navigator.geolocation) {
            this.error = 'La géolocalisation n\'est pas supportée par votre navigateur';
            this.loading = false;
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                this.userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                this.loading = false;
                this.$dispatch('location-found', this.userLocation);
            },
            (error) => {
                this.error = 'Impossible d\'obtenir votre position: ' + error.message;
                this.loading = false;
            }
        );
    }
}));

Alpine.start();
