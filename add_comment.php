<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
$file = "comments.json";

if(!isset($_SESSION['user'])){
    echo json_encode([
        "status" => "error",
        "message" => "Utilisateur non connecté"
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'),true);

if(
    empty($data['text']) ||
    empty($data['categorie']) ||
    empty($data['pays']) ||
    empty($data['indicateur'])
){
    echo json_encode([
        "status" => "error", 
        "message" => "Données manquantes"
    ]);
    exit;
}

$comments = [];
if(file_exists($file)){
    $comments = json_decode(file_get_contents($file), true);
    if(!is_array($comments)){
        $comments = [];
    }
}

$nomUtilisateur =
    $_SESSION['user']['prenom'] ??
    $_SESSION['user']['username'] ??
    'Utilisateur';

$newComment = [
    "user" => $nomUtilisateur,
    "text" => trim($data['text']),
    "categorie" => $data['categorie'],
    "pays" => $data['pays'],
    "indicateur" => $data['indicateur'],
    "date" => date('Y-m-d H:i:s')
];

$comments[] = $newComment;

file_put_contents($file, json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo json_encode(["status" => "success"]);
?>
