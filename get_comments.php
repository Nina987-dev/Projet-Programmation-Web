<?php

header('Content-Type: application/json; charset=utf-8');

$file = "comments.json";

$categorie = $_GET['categorie'] ?? '';
$pays = $_GET['pays'] ?? '';
$indicateur = $_GET['indicateur'] ?? '';

if(!file_exists($file)){
    echo json_encode([]);
    exit;
}

$comments = json_decode(file_get_contents($file), true);

if(!is_array($comments)){
    echo json_encode([]);
    exit;
}

$result = array_filter($comments, function($c) use ($categorie, $pays, $indicateur){
    return $c['categorie'] === $categorie &&
           $c['pays'] === $pays &&
           $c['indicateur'] === $indicateur;
});
echo json_encode(array_values($result));
?>
