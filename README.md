# GeoPulse Live

Application web de visualisation des tendances mondiales en temps réel avec un système de commentaires. (Version en cours de développement)

## Prérequis
* **Serveur web local** : XAMPP ou WAMP (avec Apache et PHP).
* **Base de données** : PostgreSQL.
* **Python 3** : Pour les scripts de collecte de données.

## Installation et Configuration

### 1. Base de données et Backend Python
* Créer une base de données PostgreSQL.
* Vérifier que le fichier `.env` pointe vers la bonne base (exemple : `DB_NAME=geopulse_db`).
* Exécuter le script d'initialisation pour créer les tables :
  `python init_db.py`
* Lancer le script Python pour récupérer les données (NewsAPI, AlphaVantage) :
  `python collecteur.py`

### 2. Serveur Web (PHP)
* Placer le dossier complet du projet dans le répertoire `htdocs` (pour XAMPP) ou `www` (pour WAMP).
* Dans le fichier de configuration `php.ini` d'Apache, s'assurer que les extensions PostgreSQL sont activées en enlevant le point-virgule au début des lignes :
  * `extension=pdo_pgsql`
  * `extension=pgsql`
* Démarrer le module Apache depuis le panneau de contrôle XAMPP/WAMP.

## Utilisation
Ouvrir un navigateur web et accéder à la page principale :
`http://localhost/Projet%20programmation%20web/geopulse.html`
