<?php
header('Content-Type: application/json; charset=utf-8');

$file = 'tendances.json';

if (!file_exists($file)) {
    http_response_code(500);
    echo json_encode(["error" => "Fichier tendances.json introuvable"]);
    exit;
}

$data = json_decode(file_get_contents($file), true);

if (!$data) {
    http_response_code(500);
    echo json_encode(["error" => "Impossible de lire le fichier JSON"]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'categories') {
    $categories = [];
    foreach ($data as $key => $value) {
        if ($key !== 'annees') {
            $categories[] = $key;
        }
    }
    echo json_encode($categories);
    exit;
}

if ($action === 'pays') {
    $categorie = $_GET['categorie'] ?? '';

    if (
        empty($categorie) ||
        !isset($data[$categorie]) ||
        !isset($data[$categorie]['pays'])
    ) {
        echo json_encode([]);
        exit;
    }

    $pays = array_keys($data[$categorie]['pays']);
    echo json_encode($pays);
    exit;
}

if ($action === 'indicateurs') {
    $categorie = $_GET['categorie'] ?? '';
    $pays = $_GET['pays'] ?? '';

    if (
        empty($categorie) ||
        empty($pays) ||
        !isset($data[$categorie]['pays'][$pays])
    ) {
        echo json_encode([]);
        exit;
    }

    $indicateurs = array_keys($data[$categorie]['pays'][$pays]);
    echo json_encode($indicateurs);
    exit;
}

if ($action === 'values') {
    $categorie = $_GET['categorie'] ?? '';
    $pays = $_GET['pays'] ?? '';
    $indicateur = $_GET['indicateur'] ?? '';

    if (
        empty($categorie) ||
        empty($pays) ||
        empty($indicateur) ||
        !isset($data[$categorie]['pays'][$pays][$indicateur])
    ) {
        http_response_code(400);
        echo json_encode(["error" => "Paramètres invalides"]);
        exit;
    }

    $annees = $data['annees'] ?? [];
    $valeurs = $data[$categorie]['pays'][$pays][$indicateur];

    echo json_encode([
        "categorie" => $categorie,
        "pays" => $pays,
        "indicateur" => $indicateur,
        "annees" => $annees,
        "valeurs" => $valeurs
    ]);
    exit;
}

http_response_code(400);
echo json_encode(["error" => "Action inconnue"]);
