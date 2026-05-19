# RideM3aya - Guide d'Installation

## 🚀 Installation complète

### 1. Installer les dépendances PHP

```bash
composer install
```

### 2. Installer les dépendances Node.js

```bash
npm install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer la base de données

Éditez le fichier `.env` et configurez votre base de données:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ridem3aya
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 5. Exécuter les migrations

```bash
php artisan migrate
```

### 6. Compiler les assets

```bash
npm run build
```

### 7. Lier le storage (optionnel)

```bash
php artisan storage:link
```

### 8. Démarrer le serveur de développement

```bash
php artisan serve
```

Dans un autre terminal, lancez Vite:

```bash
npm run dev
```

## 🎨 Nouvelles fonctionnalités ajoutées

### 1. Carte interactive avec géolocalisation (Leaflet.js)
- Carte Leaflet intégrée sur la page de recherche de trajets
- Bouton "Ma position" pour géolocaliser l'utilisateur
- Marqueurs interactifs pour chaque trajet
- Itinéraire visuel sur la page de détails

### 2. Design moderne avec animations et mode sombre
- Animations fluides (fade-in, slide, float, pulse-glow)
- Mode sombre avec toggle dans la navigation
- Glassmorphism effects
- Scrollbar personnalisé
- Design responsive

### 3. Auto-complétion des villes marocaines
- Liste de 25 villes marocaines prédéfinies
- Suggestions automatiques lors de la saisie
- Interface intuitive avec Alpine.js

### 4. Système de messagerie
- Page de messagerie pour contacter les conducteurs
- Modal de message sur la page de détails du trajet
- Indicateur de messages non lus

### 5. Export PDF
- Génération de PDF professionnels pour les trajets
- Design moderne avec le branding RideM3aya
- Informations complètes du trajet et du conducteur

### 6. Système de favoris
- Ajout/retirer des trajets aux favoris
- Page dédiée aux trajets favoris
- Interface avec cartes animées

### 7. Optimisations cache et performances
- Cache des résultats de recherche (5 minutes)
- Cache des trajets à venir (10 minutes)
- Invalidation automatique du cache lors des modifications
- Chargement optimisé des relations

### 8. Photos du Maroc en arrière-plan
- Images Unsplash du Maroc intégrées
- Backgrounds variés (désert, ville, côte)
- Effets de superposition élégants

## 📁 Fichiers modifiés/créés

### Configuration
- `composer.json` - Ajout de barryvdh/laravel-dompdf
- `tailwind.config.js` - Ajout des animations et backgrounds marocains
- `resources/css/app.css` - Animations personnalisées et styles Leaflet
- `resources/js/app.js` - Composants Alpine.js (autocomplete, dark mode, geolocation)

### Migrations
- `database/migrations/2026_05_18_155013_add_coordinates_to_trips_table.php` - Correction des références de colonnes

### Contrôleurs
- `app/Http/Controllers/TripController.php` - Ajout du cache et imports

### Vues
- `resources/views/layouts/app.blade.php` - Ajout de x-cloak
- `resources/views/layouts/navigation.blade.php` - Mode sombre, liens favoris/messages
- `resources/views/welcome.blade.php` - Background marocain
- `resources/views/trips/index.blade.php` - Géolocalisation, autocomplete
- `resources/views/trips/pdf.blade.php` - Design PDF amélioré
- `resources/views/messages/index.blade.php` - Page de messagerie (créée)
- `resources/views/favorites/index.blade.php` - Page des favoris (créée)

## 🔧 Commandes utiles

### Nettoyer le cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimiser l'application
```bash
php artisan optimize
composer dump-autoload
npm run build
```

### Créer un utilisateur admin
```bash
php artisan tinker
>>> $user = \App\Models\User::create([
...     'name' => 'Admin',
...     'email' => 'admin@ridem3aya.ma',
...     'password' => bcrypt('password'),
...     'role' => 'admin',
...     'is_active' => true
... ]);
```

## 🎯 Utilisation

### Rechercher un trajet
1. Allez sur la page d'accueil
2. Utilisez le formulaire de recherche avec auto-complétion
3. Cliquez sur "Ma position" pour vous géolocaliser
4. Consultez la carte interactive

### Contacter un conducteur
1. Allez sur la page de détails d'un trajet
2. Cliquez sur "Contacter le conducteur"
3. Envoyez votre message via le modal

### Exporter en PDF
1. Allez sur la page de détails d'un trajet
2. Cliquez sur l'icône de téléchargement PDF
3. Le PDF sera généré automatiquement

### Gérer les favoris
1. Cliquez sur le cœur sur n'importe quel trajet
2. Accédez à vos favoris via la navigation
3. Retirez les favoris en cliquant à nouveau sur le cœur

## 🐛 Résolution de problèmes

### Erreur de migration
```bash
php artisan migrate:fresh
```

### Problème avec Leaflet
Assurez-vous que Leaflet CSS et JS sont bien inclus dans le layout.

### Cache bloqué
```bash
php artisan cache:clear
php artisan queue:work
```

## 📝 Notes importantes

- Le mode sombre est persistant (localStorage)
- Les suggestions de villes sont limitées aux grandes villes marocaines
- Le cache est automatiquement invalidé lors des créations/modifications de trajets
- Les images de fond proviennent d'Unsplash (nécessite une connexion internet)

## 🇲🇦 RideM3aya - Voyagez ensemble à travers le Maroc
