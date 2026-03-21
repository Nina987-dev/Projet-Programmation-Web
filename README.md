# GeoPulse Live

GeoPulse Live est une application web qui centralise et affiche en temps réel des tendances mondiales (actualités, taux de change) récupérées via des API tierces. Elle intègre également un système de commentaires dynamique pour interagir sur chaque sujet abordé.

*(Version en cours de développement)*

## Prérequis
* **Serveur web local** : XAMPP ou WAMP (avec Apache et PHP).
* **Base de données** : PostgreSQL.
* **Python 3** : Pour les scripts de collecte de données.

## Installation et Configuration

### 1. Base de données et Backend Python
* Créer une base de données PostgreSQL.
* Créer un fichier `.env` à la racine du projet et configurer les accès (exemple : `DB_NAME=geopulse_db`).
* Exécuter le script d'initialisation pour créer les tables :
  `python init_db.py`

### 2. Serveur Web (PHP)
* Placer le dossier complet du projet dans le répertoire `htdocs` (pour XAMPP) ou `www` (pour WAMP).
* Dans le fichier de configuration `php.ini` d'Apache, s'assurer que les extensions PostgreSQL sont activées en enlevant le point-virgule au début des lignes :
  * `extension=pdo_pgsql`
  * `extension=pgsql`
* Démarrer le module Apache depuis le panneau de contrôle XAMPP/WAMP.

## Lancement du Projet

Pour démarrer l'application et actualiser les données, suivez ces étapes :

1. **Collecte des données** :
   Lancez le collecteur pour récupérer les dernières tendances et alimenter la base :
   `python collecteur.py`

2. **Accès à l'interface** :
   Ouvrez votre navigateur web et accédez à la page principale :
   `http://localhost/Projet%20programmation%20web/geopulse.html`

## Utilisation
Une fois sur l'interface, vous pouvez :
* Visualiser les dernières tendances mondiales en temps réel.
* Cliquer sur "Actualiser les tendances" pour recharger les données de la base.
* Lire et poster des commentaires sous chaque carte de tendance.
