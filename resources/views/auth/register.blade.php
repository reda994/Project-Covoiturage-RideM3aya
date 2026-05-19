<x-guest-layout>
    <div x-data="{ 
        step: 1, 
        role: 'passenger',
        showPassword: false,
        showConfirmPassword: false,
        phone: '+212 ',
        
        // Permis de conduire
        license_number: '',
        license_issue_date: '',
        license_category: 'B',
        license_country: 'Maroc',
        license_photo_recto_url: null,
        license_photo_verso_url: null,
        license_selfie_url: null,

        // Véhicule
        brand: 'Dacia',
        model: '',
        year: '2023',
        color: '#10b981',
        seats_total: '5',
        fuel_type: 'Diesel',
        consumption: '',
        plate_number: '',
        carte_grise_url: null,
        carte_grise_name: null,
        insurance_url: null,
        insurance_name: null,
        insurance_expiry: '',
        vehicle_photos_urls: [],
        options: [],

        // Modal Zoom
        zoomedImage: null,
        accept_terms: false,

        previewImage(e, propName) {
            const file = e.target.files[0];
            if (file) {
                this[propName] = URL.createObjectURL(file);
            }
        },

        previewMultiple(e) {
            const files = Array.from(e.target.files).slice(0, 6);
            this.vehicle_photos_urls = files.map(file => URL.createObjectURL(file));
        },

        previewDoc(e, propUrl, propName) {
            const file = e.target.files[0];
            if (file) {
                this[propName] = file.name;
                if (file.type.match('image.*')) {
                    this[propUrl] = URL.createObjectURL(file);
                } else {
                    this[propUrl] = 'pdf-icon';
                }
            }
        }
    }" class="relative">

        <!-- Modal Zoom Premium -->
        <div x-show="zoomedImage" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 scale-95" 
             x-transition:enter-end="opacity-100 scale-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 scale-100" 
             x-transition:leave-end="opacity-0 scale-95" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" 
             @click="zoomedImage = null" 
             style="display: none;">
            <div class="relative max-w-4xl w-full flex flex-col items-center">
                <button type="button" class="absolute -top-12 right-0 text-white hover:text-emerald-400 text-lg font-bold flex items-center gap-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Fermer
                </button>
                <img :src="zoomedImage" class="max-h-[80vh] rounded-2xl shadow-2xl border-4 border-white/20 object-contain">
                <p class="text-white/80 mt-4 text-sm font-semibold">Cliquez n'importe où pour fermer le zoom</p>
            </div>
        </div>

        <!-- En-tête Dynamique -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-black font-heading text-gray-900 dark:text-white tracking-tight">
                Créer un compte
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Rejoignez la communauté de covoiturage RideM3aya.
            </p>
            
            <!-- Indicateur de progression Passager -->
            <div x-show="role === 'passenger'" class="mt-6">
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                    <span :class="step >= 1 ? 'text-emerald-500' : ''">1. Informations</span>
                    <span :class="step >= 2 ? 'text-emerald-500' : ''">2. Rôle</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full mt-2 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-600 transition-all duration-500"
                         :style="`width: ${step === 1 ? '50' : '100'}%`"></div>
                </div>
            </div>

            <!-- Indicateur de progression Conducteur Dynamique (4 ÉTAPES) -->
            <div x-show="role === 'driver'" class="mt-6" style="display: none;">
                <div class="flex justify-between items-center relative">
                    <!-- Barre de progression de fond -->
                    <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-gray-100 dark:bg-gray-700 rounded-full -z-10">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-600 transition-all duration-500"
                             :style="`width: ${(step === 1 || step === 2) ? '12.5' : (step === 3 ? '37.5' : (step === 4 ? '62.5' : '100'))}%`"></div>
                    </div>

                    <!-- Étape 1 : Informations -->
                    <div class="flex flex-col items-center">
                        <div :class="(step === 1 || step === 2) ? 'bg-emerald-500 text-white ring-4 ring-emerald-500/20' : (step > 2 ? 'bg-teal-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-400 border border-gray-200 dark:border-gray-700')"
                             class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow transition-all duration-300">
                            <span x-show="step > 2">✓</span>
                            <span x-show="step <= 2">1</span>
                        </div>
                        <span :class="(step === 1 || step === 2) ? 'text-emerald-500 font-extrabold' : 'text-gray-400'" class="text-[10px] uppercase font-bold tracking-wider mt-1.5 transition">Infos</span>
                    </div>

                    <!-- Étape 2 : Permis -->
                    <div class="flex flex-col items-center">
                        <div :class="step === 3 ? 'bg-emerald-500 text-white ring-4 ring-emerald-500/20' : (step > 3 ? 'bg-teal-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-400 border border-gray-200 dark:border-gray-700')"
                             class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow transition-all duration-300">
                            <span x-show="step > 3">✓</span>
                            <span x-show="step <= 3">2</span>
                        </div>
                        <span :class="step === 3 ? 'text-emerald-500 font-extrabold' : 'text-gray-400'" class="text-[10px] uppercase font-bold tracking-wider mt-1.5 transition">Permis</span>
                    </div>

                    <!-- Étape 3 : Véhicule -->
                    <div class="flex flex-col items-center">
                        <div :class="step === 4 ? 'bg-emerald-500 text-white ring-4 ring-emerald-500/20' : (step > 4 ? 'bg-teal-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-400 border border-gray-200 dark:border-gray-700')"
                             class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow transition-all duration-300">
                            <span x-show="step > 4">✓</span>
                            <span x-show="step <= 4">3</span>
                        </div>
                        <span :class="step === 4 ? 'text-emerald-500 font-extrabold' : 'text-gray-400'" class="text-[10px] uppercase font-bold tracking-wider mt-1.5 transition">Véhicule</span>
                    </div>

                    <!-- Étape 4 : Confirmation -->
                    <div class="flex flex-col items-center">
                        <div :class="step === 5 ? 'bg-emerald-500 text-white ring-4 ring-emerald-500/20' : 'bg-white dark:bg-gray-800 text-gray-400 border border-gray-200 dark:border-gray-700'"
                             class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow transition-all duration-300">
                            <span>4</span>
                        </div>
                        <span :class="step === 5 ? 'text-emerald-500 font-extrabold' : 'text-gray-400'" class="text-[10px] uppercase font-bold tracking-wider mt-1.5 transition">Confirmation</span>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Input caché pour soumettre le rôle sélectionné -->
            <input type="hidden" name="role" :value="role">

            <!-- ============================================== -->
            <!-- ÉTAPE 1 : Informations de base                 -->
            <!-- ============================================== -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="space-y-4">
                    <!-- Nom Complet -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Nom complet</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                   placeholder="Ex: Mohamed El Alami" 
                                   class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition font-sans">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Adresse email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                   placeholder="Ex: mohamed@example.com" 
                                   class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition font-sans">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Numéro de téléphone</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input type="tel" id="phone" name="phone" x-model="phone" required
                                   class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition font-sans">
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="new-password"
                                   placeholder="Minimum 8 caractères"
                                   class="pl-10 pr-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition font-sans">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Confirmation du mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="Saisissez à nouveau"
                                   class="pl-10 pr-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition font-sans">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between">
                    <a class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-emerald-500 dark:hover:text-emerald-450 transition" href="{{ route('login') }}">
                        Déjà inscrit ?
                    </a>
                    
                    <button type="button" @click="step = 2" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5 font-sans">
                        Étape suivante
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- ÉTAPE 2 : Choix du rôle                        -->
            <!-- ============================================== -->
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-y-0">
                <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-4 font-sans text-center">Quel est votre rôle principal ?</p>
                
                <div class="grid md:grid-cols-2 gap-4 mb-6 font-sans">
                    <!-- Carte Passager -->
                    <div @click="role = 'passenger'" 
                         :class="role === 'passenger' ? 'border-emerald-500 bg-emerald-50/50 dark:bg-emerald-950/20 shadow-emerald-100 dark:shadow-none ring-2 ring-emerald-500/30' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300 dark:hover:border-emerald-700'"
                         class="role-card border-2 rounded-2xl p-6 cursor-pointer transition-all duration-300 transform hover:-translate-y-1 text-center">
                        <div class="w-16 h-16 mx-auto bg-emerald-100 dark:bg-emerald-900/50 rounded-full flex items-center justify-center text-emerald-600 dark:text-emerald-450 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-heading font-extrabold text-xl mt-4 text-gray-900 dark:text-white">Passager</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Je souhaite réserver des trajets et voyager simplement.</p>
                    </div>
                    
                    <!-- Carte Conducteur -->
                    <div @click="role = 'driver'" 
                         :class="role === 'driver' ? 'border-emerald-500 bg-emerald-50/50 dark:bg-emerald-950/20 shadow-emerald-100 dark:shadow-none ring-2 ring-emerald-500/30' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-300 dark:hover:border-emerald-700'"
                         class="role-card border-2 rounded-2xl p-6 cursor-pointer transition-all duration-300 transform hover:-translate-y-1 text-center">
                        <div class="w-16 h-16 mx-auto bg-emerald-100 dark:bg-emerald-900/50 rounded-full flex items-center justify-center text-emerald-600 dark:text-emerald-450 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <h3 class="font-heading font-extrabold text-xl mt-4 text-gray-900 dark:text-white">Conducteur</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Je propose des trajets libres et partage mes frais de route.</p>
                    </div>
                </div>

                <div x-show="role === 'passenger'" class="mt-6 mb-4">
                    <label class="flex items-start gap-2.5 cursor-pointer text-xs">
                        <input type="checkbox" x-model="accept_terms" :required="role === 'passenger'"
                               class="mt-0.5 rounded border-gray-300 dark:border-gray-700 text-emerald-500 focus:ring-emerald-500 shadow-sm dark:bg-gray-900">
                        <span class="text-gray-500 dark:text-gray-400 leading-normal">
                            J'accepte les <a href="#" class="text-emerald-600 dark:text-emerald-400 font-bold hover:underline">conditions générales d'utilisation</a> de RideM3aya.
                        </span>
                    </label>
                </div>

                <div class="mt-8 flex items-center justify-between">
                    <button type="button" @click="step = 1" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-emerald-500 dark:hover:text-emerald-450 transition">
                        Retour
                    </button>
                    
                    <!-- Si Passager, bouton direct de création de compte -->
                    <button x-show="role === 'passenger'" type="submit" :disabled="!accept_terms"
                            :class="accept_terms ? 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-teal-500/20' : 'bg-gray-300 dark:bg-gray-700 cursor-not-allowed text-gray-400 dark:text-gray-500'"
                            class="text-white font-bold py-3 px-8 rounded-2xl shadow-lg transition-all transform hover:-translate-y-0.5">
                        Créer mon compte
                    </button>

                    <!-- Si Conducteur, bouton étape suivante -->
                    <button x-show="role === 'driver'" type="button" @click="step = 3" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5" style="display: none;">
                        Étape suivante
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- ÉTAPE 3 : Permis de conduire (CONDUCTEUR)       -->
            <!-- ============================================== -->
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="space-y-4">
                    <div class="border-b border-gray-100 dark:border-gray-700/80 pb-3 mb-4">
                        <h3 class="text-lg font-black font-heading text-gray-900 dark:text-white">Détails du Permis de Conduire</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Ces informations nous permettent de certifier votre profil.</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Numéro du permis -->
                        <div>
                            <label for="license_number" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Numéro de permis</label>
                            <input type="text" id="license_number" name="license_number" x-model="license_number" :required="role === 'driver'"
                                   placeholder="Ex: 01/123456" 
                                   class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                        </div>

                        <!-- Date d'obtention -->
                        <div>
                            <label for="license_issue_date" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Date d'obtention</label>
                            <input type="date" id="license_issue_date" name="license_issue_date" x-model="license_issue_date" :required="role === 'driver'"
                                   class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                        </div>

                        <!-- Catégorie du permis -->
                        <div>
                            <label for="license_category" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Catégorie du permis</label>
                            <select id="license_category" name="license_category" x-model="license_category" :required="role === 'driver'"
                                    class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                                <option value="A">Catégorie A (Moto)</option>
                                <option value="B">Catégorie B (Voiture)</option>
                                <option value="C">Catégorie C (Poids Lourd)</option>
                                <option value="D">Catégorie D (Autobus)</option>
                            </select>
                        </div>

                        <!-- Pays de délivrance -->
                        <div>
                            <label for="license_country" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Pays de délivrance</label>
                            <select id="license_country" name="license_country" x-model="license_country" :required="role === 'driver'"
                                    class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                                <option value="Maroc">Maroc</option>
                                <option value="France">France</option>
                                <option value="Espagne">Espagne</option>
                                <option value="Belgique">Belgique</option>
                                <option value="Italie">Italie</option>
                            </select>
                        </div>
                    </div>

                    <!-- Uploads Photos & Previews -->
                    <div class="mt-4 space-y-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Documents justificatifs</p>
                        
                        <div class="grid sm:grid-cols-3 gap-4 font-sans text-xs">
                            <!-- Permis Recto -->
                            <div class="border border-dashed border-gray-200 dark:border-gray-700 rounded-2xl p-4 text-center flex flex-col justify-between items-center bg-gray-50/50 dark:bg-gray-900/30">
                                <span>Permis Recto *</span>
                                <div class="w-20 h-14 bg-gray-200 dark:bg-gray-800 rounded-lg flex items-center justify-center mt-2 relative overflow-hidden border border-gray-100 dark:border-gray-700">
                                    <template x-if="license_photo_recto_url">
                                        <img :src="license_photo_recto_url" @click="zoomedImage = license_photo_recto_url" class="w-full h-full object-cover cursor-zoom-in">
                                    </template>
                                    <span x-show="!license_photo_recto_url" class="text-gray-400 text-lg">📷</span>
                                </div>
                                <input type="file" name="license_photo_recto" @change="previewImage($event, 'license_photo_recto_url')" accept="image/*" :required="role === 'driver'" class="mt-2 text-[10px] w-full text-center">
                            </div>

                            <!-- Permis Verso -->
                            <div class="border border-dashed border-gray-200 dark:border-gray-700 rounded-2xl p-4 text-center flex flex-col justify-between items-center bg-gray-50/50 dark:bg-gray-900/30">
                                <span>Permis Verso *</span>
                                <div class="w-20 h-14 bg-gray-200 dark:bg-gray-800 rounded-lg flex items-center justify-center mt-2 relative overflow-hidden border border-gray-100 dark:border-gray-700">
                                    <template x-if="license_photo_verso_url">
                                        <img :src="license_photo_verso_url" @click="zoomedImage = license_photo_verso_url" class="w-full h-full object-cover cursor-zoom-in">
                                    </template>
                                    <span x-show="!license_photo_verso_url" class="text-gray-400 text-lg">📷</span>
                                </div>
                                <input type="file" name="license_photo_verso" @change="previewImage($event, 'license_photo_verso_url')" accept="image/*" :required="role === 'driver'" class="mt-2 text-[10px] w-full text-center">
                            </div>

                            <!-- Selfie avec permis -->
                            <div class="border border-dashed border-gray-200 dark:border-gray-700 rounded-2xl p-4 text-center flex flex-col justify-between items-center bg-gray-50/50 dark:bg-gray-900/30">
                                <span>Selfie avec permis *</span>
                                <div class="w-20 h-14 bg-gray-200 dark:bg-gray-800 rounded-lg flex items-center justify-center mt-2 relative overflow-hidden border border-gray-100 dark:border-gray-700">
                                    <template x-if="license_selfie_url">
                                        <img :src="license_selfie_url" @click="zoomedImage = license_selfie_url" class="w-full h-full object-cover cursor-zoom-in">
                                    </template>
                                    <span x-show="!license_selfie_url" class="text-gray-400 text-lg">📷</span>
                                </div>
                                <input type="file" name="license_selfie" @change="previewImage($event, 'license_selfie_url')" accept="image/*" :required="role === 'driver'" class="mt-2 text-[10px] w-full text-center">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between">
                    <button type="button" @click="step = 2" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-emerald-500 dark:hover:text-emerald-450 transition">
                        Retour
                    </button>
                    
                    <button type="button" @click="step = 4" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5">
                        Étape suivante
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- ÉTAPE 4 : Informations du Véhicule (CONDUCTEUR)-->
            <!-- ============================================== -->
            <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="max-h-[60vh] overflow-y-auto pr-1">
                <div class="space-y-6">
                    <!-- SECTION A : Informations de base -->
                    <div>
                        <div class="border-b border-gray-100 dark:border-gray-700/80 pb-2 mb-3">
                            <h3 class="text-base font-extrabold font-heading text-gray-900 dark:text-white">Section A - Informations du Véhicule</h3>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="brand" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Marque</label>
                                <select id="brand" name="brand" x-model="brand" :required="role === 'driver'"
                                        class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                                    <option value="Dacia">Dacia</option>
                                    <option value="Renault">Renault</option>
                                    <option value="Peugeot">Peugeot</option>
                                    <option value="Volkswagen">Volkswagen</option>
                                    <option value="Toyota">Toyota</option>
                                    <option value="Hyundai">Hyundai</option>
                                    <option value="Ford">Ford</option>
                                    <option value="Mercedes">Mercedes</option>
                                </select>
                            </div>

                            <div>
                                <label for="model" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Modèle *</label>
                                <input type="text" id="model" name="model" x-model="model" :required="role === 'driver'"
                                       placeholder="Ex: Logan / Sandero / Clio" 
                                       class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                            </div>

                            <div>
                                <label for="year" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Année de fabrication</label>
                                <select id="year" name="year" x-model="year" :required="role === 'driver'"
                                        class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                                    <template x-for="yr in Array.from({length: 11}, (v, i) => 2015 + i)">
                                        <option :value="yr" x-text="yr"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Couleur</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" x-model="color" name="color" class="w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-700 p-0 overflow-hidden cursor-pointer">
                                    <input type="text" x-model="color" readonly class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm font-sans text-sm py-2 px-3">
                                </div>
                            </div>

                            <div>
                                <label for="seats_total" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Nombre de places</label>
                                <select id="seats_total" name="seats_total" x-model="seats_total" :required="role === 'driver'"
                                        class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                                    <option value="4">4 places</option>
                                    <option value="5">5 places</option>
                                    <option value="6">6 places</option>
                                    <option value="7">7 places</option>
                                    <option value="8">8 places</option>
                                    <option value="9">9 places</option>
                                </select>
                            </div>

                            <div>
                                <label for="fuel_type" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Type de carburant</label>
                                <select id="fuel_type" name="fuel_type" x-model="fuel_type" :required="role === 'driver'"
                                        class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                                    <option value="Diesel">Diesel</option>
                                    <option value="Essence">Essence</option>
                                    <option value="Electrique">Électrique</option>
                                    <option value="Hybride">Hybride</option>
                                </select>
                            </div>

                            <div>
                                <label for="consumption" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Consommation moyenne (L/100km)</label>
                                <input type="number" step="0.1" id="consumption" name="consumption" x-model="consumption" placeholder="Ex: 5.2"
                                       class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                            </div>

                            <div>
                                <label for="plate_number" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">N° Immatriculation *</label>
                                <input type="text" id="plate_number" name="plate_number" x-model="plate_number" :required="role === 'driver'"
                                       placeholder="Ex: 12345/A/1" 
                                       class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION B : Documents du véhicule -->
                    <div>
                        <div class="border-b border-gray-100 dark:border-gray-700/80 pb-2 mb-3">
                            <h3 class="text-base font-extrabold font-heading text-gray-900 dark:text-white">Section B - Documents du Véhicule</h3>
                        </div>

                        <div class="space-y-4 font-sans text-xs">
                            <div class="grid sm:grid-cols-2 gap-4">
                                <!-- Carte Grise -->
                                <div class="border border-dashed border-gray-200 dark:border-gray-700 rounded-2xl p-4 flex flex-col justify-between items-center bg-gray-50/50 dark:bg-gray-900/30">
                                    <span class="font-bold">Carte Grise (PDF ou Image) *</span>
                                    <div class="w-full flex items-center justify-center gap-2 mt-2 py-1 px-3 border rounded-xl border-gray-200 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-500 text-[10px]">
                                        <span x-text="carte_grise_name ? carte_grise_name : 'Aucun fichier sélectionné'"></span>
                                    </div>
                                    <input type="file" name="carte_grise" @change="previewDoc($event, 'carte_grise_url', 'carte_grise_name')" accept="image/*,application/pdf" :required="role === 'driver'" class="mt-2 text-[10px] w-full">
                                </div>

                                <!-- Assurance -->
                                <div class="border border-dashed border-gray-200 dark:border-gray-700 rounded-2xl p-4 flex flex-col justify-between items-center bg-gray-50/50 dark:bg-gray-900/30">
                                    <span class="font-bold">Assurance du Véhicule *</span>
                                    <div class="w-full flex items-center justify-center gap-2 mt-2 py-1 px-3 border rounded-xl border-gray-200 bg-white dark:bg-gray-900 dark:border-gray-700 text-gray-500 text-[10px]">
                                        <span x-text="insurance_name ? insurance_name : 'Aucun fichier sélectionné'"></span>
                                    </div>
                                    <input type="file" name="insurance" @change="previewDoc($event, 'insurance_url', 'insurance_name')" accept="image/*,application/pdf" :required="role === 'driver'" class="mt-2 text-[10px] w-full">
                                </div>
                            </div>

                            <!-- Échéance de l'assurance -->
                            <div>
                                <label for="insurance_expiry" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300 mb-1.5 font-sans">Date d'échéance de l'assurance</label>
                                <input type="date" id="insurance_expiry" name="insurance_expiry" x-model="insurance_expiry"
                                       class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm font-sans text-sm">
                            </div>

                            <!-- Photos du véhicule -->
                            <div class="border border-dashed border-gray-200 dark:border-gray-700 rounded-2xl p-4 bg-gray-50/50 dark:bg-gray-900/30">
                                <span class="font-bold block mb-1">Photos du véhicule (Max 6)</span>
                                <span class="text-[10px] text-gray-400 block mb-2">Importez face avant, face arrière, côtés, et habitacle.</span>
                                
                                <input type="file" name="vehicle_photos[]" multiple @change="previewMultiple($event)" accept="image/*" class="text-[10px] w-full block">

                                <div class="grid grid-cols-6 gap-2 mt-3" x-show="vehicle_photos_urls.length > 0">
                                    <template x-for="photoUrl in vehicle_photos_urls">
                                        <div class="w-full aspect-video rounded-lg overflow-hidden border border-gray-200 bg-gray-100 relative">
                                            <img :src="photoUrl" @click="zoomedImage = photoUrl" class="w-full h-full object-cover cursor-zoom-in">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION C : Options du véhicule -->
                    <div>
                        <div class="border-b border-gray-100 dark:border-gray-700/80 pb-2 mb-3">
                            <h3 class="text-base font-extrabold font-heading text-gray-900 dark:text-white">Section C - Options à bord</h3>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 font-sans text-xs">
                            <template x-for="opt in ['Climatisation', 'Bluetooth/USB', 'Wi-Fi à bord', 'Prise de recharge', 'Toit ouvrant', 'Animaux acceptés', 'Fumeurs acceptés', 'Bagages supplémentaires', 'Siège bébé']">
                                <label class="flex items-center gap-2 cursor-pointer py-1">
                                    <input type="checkbox" name="options[]" :value="opt" x-model="options"
                                           class="rounded border-gray-300 dark:border-gray-700 text-emerald-500 focus:ring-emerald-500 shadow-sm dark:bg-gray-900">
                                    <span class="text-gray-700 dark:text-gray-350" x-text="opt"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-gray-100 dark:border-gray-700/80 pt-4">
                    <button type="button" @click="step = 3" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-emerald-500 dark:hover:text-emerald-450 transition">
                        Retour
                    </button>
                    
                    <button type="button" @click="step = 5" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5">
                        Étape suivante
                    </button>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- ÉTAPE 5 : Confirmation & Récapitulatif          -->
            <!-- ============================================== -->
            <div x-show="step === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="space-y-4 font-sans text-xs max-h-[55vh] overflow-y-auto pr-1">
                    <div class="border-b border-gray-100 dark:border-gray-700/80 pb-2 mb-3">
                        <h3 class="text-lg font-black font-heading text-gray-900 dark:text-white">Récapitulatif de l'Inscription</h3>
                        <p class="text-[10px] text-gray-400">Veuillez vérifier vos informations avant de confirmer.</p>
                    </div>

                    <!-- Infos Perso -->
                    <div class="bg-gray-50/50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700/80 rounded-2xl p-4 space-y-2">
                        <p class="font-bold text-gray-800 dark:text-gray-250 uppercase tracking-wider text-[10px] border-b pb-1 dark:border-gray-800">1. Informations Personnelles</p>
                        <div class="grid grid-cols-2 gap-y-1.5">
                            <span class="text-gray-400">Nom Complet :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="document.getElementById('name').value"></span>
                            
                            <span class="text-gray-400">Adresse Email :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="document.getElementById('email').value"></span>
                            
                            <span class="text-gray-400">N° Téléphone :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="phone"></span>
                        </div>
                    </div>

                    <!-- Infos Permis -->
                    <div class="bg-gray-50/50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700/80 rounded-2xl p-4 space-y-2">
                        <p class="font-bold text-gray-800 dark:text-gray-250 uppercase tracking-wider text-[10px] border-b pb-1 dark:border-gray-800">2. Permis de conduire</p>
                        <div class="grid grid-cols-2 gap-y-1.5">
                            <span class="text-gray-400">N° de Permis :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="license_number"></span>
                            
                            <span class="text-gray-400">Date d'obtention :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="license_issue_date"></span>
                            
                            <span class="text-gray-400">Catégorie & Pays :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="`${license_category} (${license_country})`"></span>
                        </div>
                    </div>

                    <!-- Infos Véhicule -->
                    <div class="bg-gray-50/50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700/80 rounded-2xl p-4 space-y-2">
                        <p class="font-bold text-gray-800 dark:text-gray-250 uppercase tracking-wider text-[10px] border-b pb-1 dark:border-gray-800">3. Véhicule & Documents</p>
                        <div class="grid grid-cols-2 gap-y-1.5 mb-2">
                            <span class="text-gray-400">Modèle & Marque :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="`${brand} ${model} (${year})`"></span>
                            
                            <span class="text-gray-400">Immatriculation :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="plate_number"></span>
                            
                            <span class="text-gray-400">Places & Carburant :</span>
                            <span class="font-semibold text-gray-900 dark:text-white" x-text="`${seats_total} places / ${fuel_type}`"></span>
                        </div>
                        <div class="border-t pt-2 dark:border-gray-800 flex flex-wrap gap-1.5" x-show="options.length > 0">
                            <template x-for="opt in options">
                                <span class="bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 px-2.5 py-0.5 rounded-full font-semibold border border-emerald-100 dark:border-emerald-900/50" x-text="opt"></span>
                            </template>
                        </div>
                    </div>

                    <!-- CGU Checkbox -->
                    <div class="pt-2">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" x-model="accept_terms" required
                                   class="mt-0.5 rounded border-gray-300 dark:border-gray-700 text-emerald-500 focus:ring-emerald-500 shadow-sm dark:bg-gray-900">
                            <span class="text-gray-500 dark:text-gray-400 leading-normal">
                                J'accepte les <a href="#" class="text-emerald-600 dark:text-emerald-400 font-bold hover:underline">conditions générales d'utilisation</a> de RideM3aya et je certifie l'exactitude de mes documents importés.
                            </span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-gray-100 dark:border-gray-700/80 pt-4">
                    <button type="button" @click="step = 4" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-emerald-500 dark:hover:text-emerald-450 transition">
                        Retour
                    </button>
                    
                    <button type="submit" :disabled="!accept_terms"
                            :class="accept_terms ? 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-teal-500/20' : 'bg-gray-300 dark:bg-gray-700 cursor-not-allowed text-gray-400 dark:text-gray-500'"
                            class="text-white font-bold py-3.5 px-8 rounded-2xl shadow-lg transition-all transform hover:-translate-y-0.5">
                        S'inscrire et proposer des trajets
                    </button>
                </div>
            </div>

        </form>
    </div>
</x-guest-layout>
