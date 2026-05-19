<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8" x-data="{ activeTab: 'general' }">
            
            <!-- Banner de Profil Premium -->
            <div class="bg-gradient-to-r from-green-500 via-emerald-600 to-indigo-700 dark:from-green-600 dark:via-emerald-700 dark:to-indigo-800 rounded-3xl shadow-2xl p-6 md:p-8 text-white relative overflow-hidden">
                <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -left-16 -top-16 w-64 h-64 bg-black/10 rounded-full blur-2xl"></div>
                
                <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
                    <!-- Photo de Profil Interactive avec Upload Direct -->
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full border-4 border-white/30 dark:border-gray-800/50 shadow-2xl overflow-hidden relative">
                            <img id="avatarPreview" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            
                            <!-- Overlay Hover -->
                            <label for="profilePhotoInput" class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer text-xs font-semibold text-white">
                                <svg class="w-6 h-6 mb-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Modifier
                            </label>
                        </div>
                    </div>

                    <div class="text-center md:text-left flex-1">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-3">
                            <h3 class="text-3xl font-extrabold tracking-tight">{{ $user->name }}</h3>
                            @if($user->role === 'admin')
                                <span class="bg-purple-500/30 text-purple-200 border border-purple-400/30 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Admin</span>
                            @elseif($user->role === 'driver')
                                <span class="bg-emerald-500/30 text-emerald-200 border border-emerald-400/30 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Conducteur</span>
                            @else
                                <span class="bg-blue-500/30 text-blue-200 border border-blue-400/30 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Passager</span>
                            @endif
                        </div>
                        
                        <p class="text-emerald-100 mt-2 flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                            {{ $user->email }}
                        </p>
                        
                        @if($user->average_rating > 0)
                        <div class="mt-3 flex items-center justify-center md:justify-start gap-1 bg-white/10 w-fit px-3 py-1.5 rounded-xl border border-white/10 backdrop-blur-md">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $user->average_rating ? 'text-yellow-400' : 'text-white/20' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                            <span class="text-xs font-bold ml-1 text-yellow-300">{{ number_format($user->average_rating, 1) }} / 5</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Layout Principal en Grille -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
                
                <!-- Menu / Navigation des Onglets -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 space-y-2">
                    <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg shadow-teal-500/20' : 'text-gray-750 dark:text-gray-300 hover:bg-gray-55 dark:hover:bg-gray-700'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informations Générales
                    </button>
                    
                    <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg shadow-teal-500/20' : 'text-gray-750 dark:text-gray-300 hover:bg-gray-55 dark:hover:bg-gray-700'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Sécurité & Mot de Passe
                    </button>
                    
                    <button @click="activeTab = 'danger'" :class="activeTab === 'danger' ? 'bg-red-500 text-white shadow-lg shadow-red-500/20' : 'text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Suppression de Compte
                    </button>
                </div>

                <!-- Zone de Contenu des Onglets -->
                <div class="lg:col-span-3">
                    
                    <!-- Onglet : Informations Générales -->
                    <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                            Informations Générales
                        </h3>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Input file caché pour photo de profil -->
                            <input type="file" id="profilePhotoInput" name="profile_photo" class="hidden" accept="image/*">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nom Complet -->
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nom Complet</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Adresse Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <label for="phone" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Numéro de Téléphone</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </div>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition" placeholder="Ex: +212 6XX XX XX XX">
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>

                                <!-- Rôle (Désactivé car modifiable uniquement par l'admin ou via flow dédié) -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Rôle Actuel</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        </div>
                                        <input type="text" value="{{ ucfirst($user->role) }}" disabled class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/55 text-gray-500 dark:text-gray-400 cursor-not-allowed shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Biographie -->
                            <div>
                                <label for="bio" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Biographie / À Propos de Moi</label>
                                <textarea id="bio" name="bio" rows="4" class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition" placeholder="Parlez brièvement de vous ou de vos préférences de voyage...">{{ old('bio', $user->bio) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                            </div>

                            <!-- Bouton Enregistrer -->
                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5">
                                    Enregistrer les modifications
                                </button>
                                
                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-semibold text-emerald-600 dark:text-emerald-450 flex items-center gap-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Enregistré avec succès !
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Onglet : Sécurité & Mot de Passe -->
                    <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                            Sécurité & Mot de Passe
                        </h3>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <!-- Mot de passe actuel -->
                            <div>
                                <label for="update_password_current_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Mot de passe actuel</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" id="update_password_current_password" name="current_password" class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition" autocomplete="current-password">
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <!-- Nouveau mot de passe -->
                            <div>
                                <label for="update_password_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nouveau mot de passe</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" id="update_password_password" name="password" class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition" autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirmer le mot de passe -->
                            <div>
                                <label for="update_password_password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Confirmer le nouveau mot de passe</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    </div>
                                    <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition" autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5">
                                    Mettre à jour le mot de passe
                                </button>

                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-semibold text-emerald-600 dark:text-emerald-450 flex items-center gap-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Mot de passe mis à jour !
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Onglet : Suppression de Compte -->
                    <div x-show="activeTab === 'danger'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                        <h3 class="text-xl font-extrabold text-red-650 dark:text-red-400 border-b border-gray-100 dark:border-gray-700 pb-4 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Zone de Danger
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de procéder, veuillez télécharger toutes les données ou informations importantes que vous souhaitez conserver.
                        </p>

                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-600 hover:bg-red-750 text-white font-bold py-3.5 px-8 rounded-2xl shadow-lg shadow-red-500/20 transition-all transform hover:-translate-y-0.5">
                            Supprimer définitivement mon compte
                        </button>

                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('profile.destroy') }}" class="p-6 md:p-8 bg-white dark:bg-gray-800 rounded-3xl">
                                @csrf
                                @method('delete')

                                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2 mb-2">
                                    Confirmer la suppression
                                </h2>

                                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                                    Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement et de manière irréversible votre compte.
                                </p>

                                <div class="mb-6">
                                    <label for="password" class="sr-only">Mot de passe</label>
                                    <input type="password" id="password" name="password" placeholder="Saisissez votre mot de passe" class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-red-500 focus:ring-red-500 shadow-sm transition">
                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button" x-on:click="$dispatch('close')" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold py-3 px-6 rounded-2xl transition">
                                        Annuler
                                    </button>

                                    <button type="submit" class="bg-red-600 hover:bg-red-750 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-red-500/20 transition">
                                        Confirmer la suppression
                                    </button>
                                </div>
                            </form>
                        </x-modal>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Script JS d'instant preview pour la photo de profil -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('profilePhotoInput');
            const avatarPreview = document.getElementById('avatarPreview');

            if (fileInput && avatarPreview) {
                fileInput.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            avatarPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</x-app-layout>
