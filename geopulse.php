<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: auth.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoPulse Live - Tendances Mondiales</title>
    <link rel="stylesheet" href="style.css?v=2">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Pour la creation de graphes -->
</head>
<body>
    <div class="container">
        <header>
            <h1>GeoPulse Live</h1>
            <p>
                Bienvenue,
                <?php echo htmlspecialchars($_SESSION['user']['prenom'] ?? $_SESSION['user']['username'] ?? 'Utilisateur', ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <div class="top-actions">
                <button id="btn-load">Afficher les données</button>
                <a href="logout.php" class="logout-link">Déconnexion</a>
            </div>
        </header>

        <section class="card">
            <h2>Carte du monde</h2>
            <p>Cliquez sur un pays pour le sélectionner.</p>

            <div class="map-container">
                <img src="monde.png" alt="carte du monde" class="world-map">

                <button class="map-point france" data-country="France" title="France"></button>
                <button class="map-point usa" data-country="USA" title="USA"></button>
                <button class="map-point chine" data-country="Chine" title="Chine"></button>
                <button class="map-point algerie" data-country="Algerie" title="Algerie"></button>
                <button class="map-point australie" data-country="Australie" title="Australie"></button>
            </div>

            <div id="selected-country-info" class="data-info">
                <p><strong>Pays sélectionné :</strong> Aucun</p>
            </div>
        </section>

        <section class="filters card">
            <h2>Filters</h2>

            <div class="filters-grid">
                <div class="filter-group">
                    <label for="categorie">Catégorie</label>
                    <select id="categorie">
                        <option value="">--Choisir une catégorie --</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="pays">Pays</label>
                    <select id="pays" disabled>
                        <option value="">-- Choisir un pays --</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="indicateur">Indicateur</label>
                    <select id="indicateur" disabled>
                        <option value="">-- Choisir un indicateur --</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="card">
            <h2 id="chart-title">Visualisation</h2>
            <canvas id="trendChart"></canvas>
            <div id="data-info" class="data-info"></div>
        </section>

        <div id="comments-section" class="card" style="display: none;">
            <h3>Commentaires</h3>

            <div id="comments-list"><em>Aucun commentaire</em></div>

            <form id="comment-form" class="comment-form">
                <textarea id="comment-text" placeholder="Votre commentaire" required></textarea>
                <button type="submit">Ajouter</button>
            </form>

            <div id="comment-msg"></div>
        </div>
    </div>

    <script src="script.js?v=2"></script>
</body>
</html>
