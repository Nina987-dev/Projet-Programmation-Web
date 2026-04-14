# GeoPulse Live

GeoPulse Live est une application web interactive permettant de visualiser des données mondiales (économie, population, climat) sous forme de graphiques dynamiques.

L’objectif du projet est de transformer des données brutes en une interface claire, intuitive et interactive, facilitant leur compréhension et leur analyse.

L’application repose sur une architecture simple :
Frontend (JavaScript) → Backend (PHP) → Fichiers JSON

## Fonctionnalités

- Sélection d’une catégorie (économie, population, climat)
- Choix d’un pays via une carte interactive ou une liste déroulante
- Sélection d’un indicateur
- Affichage dynamique de graphiques (Chart.js)
- Système de commentaires utilisateurs
- Authentification (inscription / connexion)

## Prérequis

- Serveur web local : XAMPP ou WAMP (Apache + PHP)
- Navigateur web moderne (Chrome recommandé)

## Installation

1. Cloner ou télécharger le projet
2. Placer le dossier dans :
   - `htdocs` (XAMPP)
   - ou `www` (WAMP)

3. Démarrer Apache depuis le panneau de contrôle

## Lancement

Ouvrir dans le navigateur : http://localhost/monprojet/geopulse.php


## Structure du projet

- `geopulse.php` : interface principale
- `script.js` : gestion des interactions et requêtes dynamiques
- `style.css` : design de l’application
- `get_data.php` : récupération des données (API simplifiée)
- `auth.php` : interface de connexion
- `process_login.php / process_register.php` : gestion des utilisateurs
- `get_comments.php / add_comment.php` : gestion des commentaires
- `logout.php` : déconnexion
- `tendances.json` : données principales
- `users.json` : utilisateurs
- `comments.json` : commentaires

## Fonctionnement

Les données sont stockées sous format JSON et exploitées dynamiquement par le backend PHP.

Lorsqu’un utilisateur effectue une action :
1. JavaScript envoie une requête au serveur
2. PHP lit et filtre les données JSON
3. Les données sont renvoyées au format JSON
4. Le frontend met à jour l’interface sans rechargement

## Remarques

Ce projet a été réalisé dans un cadre pédagogique.  
Le choix du format JSON permet de simplifier l’architecture tout en mettant en évidence les mécanismes fondamentaux du développement web (requêtes, traitement de données, interaction utilisateur).

Une évolution vers une base de données relationnelle (MySQL) peut être envisagée pour améliorer la scalabilité et les performances.
