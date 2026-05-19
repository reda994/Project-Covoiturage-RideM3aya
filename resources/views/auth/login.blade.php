<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div x-data="{ showPassword: false }">
        <!-- En-tête -->
        <div class="mb-8">
            <h2 class="text-2xl font-black font-heading text-gray-900 dark:text-white tracking-tight">
                Bon retour parmi nous
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Connectez-vous pour retrouver vos trajets et contacts.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Adresse Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1.5 font-sans">Adresse email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="Ex: mohamed@example.com"
                           class="pl-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition font-sans">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mot de passe -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 font-sans">Mot de passe</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                           placeholder="Saisissez votre mot de passe"
                           class="pl-10 pr-10 block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition font-sans">
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Se souvenir de moi -->
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" name="remember" 
                           class="rounded border-gray-300 dark:border-gray-700 text-emerald-500 focus:ring-emerald-500 shadow-sm transition dark:bg-gray-900">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 font-sans">Se souvenir de moi</span>
                </label>
            </div>

            <!-- Bouton de connexion -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5 font-sans">
                    Se connecter
                </button>
            </div>

            <!-- Lien d'inscription -->
            <div class="text-center pt-2">
                <p class="text-sm text-gray-500 dark:text-gray-450 font-sans">
                    Pas encore de compte ? 
                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                        Créer un compte
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
