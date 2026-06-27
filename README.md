# 🚗 RideM3aya - Plateforme de Covoiturage au Maroc

![Laravel Version](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel)
![PHP Version](https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php)
![MySQL Version](https://img.shields.io/badge/MySQL-8-orange?style=for-the-badge&logo=mysql)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 🌟 À propos du projet

**RideM3aya** (prononcé "Ride With Me" en darija marocaine) est une plateforme de covoiturage moderne permettant aux Marocains de partager leurs trajets quotidiens de manière simple, économique et écologique.

---

## ✨ Fonctionnalités principales

| Module | Fonctionnalités |
|--------|----------------|
| 👥 Utilisateurs | 3 rôles (Passager/Conducteur/Admin), Profil personnalisable, Photo de profil |
| 🚗 Conducteurs | Gestion des véhicules, Création de trajets, Gestion des réservations |
| 🎫 Passagers | Recherche avancée, Réservation en ligne, Système d'avis |
| ⭐ Évaluations | Notation 5 étoiles, Commentaires, Note moyenne des conducteurs |
| 💬 Messagerie | Chat en temps réel entre passagers et conducteurs |
| 🔔 Notifications | Alertes in-app, Confirmations email, Notifications temps réel |
| 👑 Admin | Dashboard complet, Gestion utilisateurs, Modération des trajets |
| 📍 Géolocalisation | Carte interactive, Détection automatique de position |

---
##Premiere inteface
<img width="1920" height="915" alt="image" src="https://github.com/user-attachments/assets/6f6899b1-1792-4f5d-91f3-5feda4d7b80d" />


## 🚀 Installation rapide

### Prérequis
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM

### Commandes d'installation

```bash
# 1. Cloner le projet
git clone https://github.com/reda994/Project-Covoiturage-RideM3aya.git
cd Project-Covoiturage-RideM3aya

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
DB_DATABASE=ridem3aya
DB_USERNAME=root
DB_PASSWORD=

# 5. Exécuter les migrations et seeders
php artisan migrate:fresh --seed

# 6. Compiler les assets
npm run build

# 7. Lancer le serveur
php artisan serve
