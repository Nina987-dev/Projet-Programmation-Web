<?php
session_start();

$file = "users.json";
if( empty($_POST['nom']) ||
    empty($_POST['prenom']) ||
    empty($_POST['email']) ||
    empty($_POST['password'])
){
    header("Location: auth.php?error=empty&show=register");
    exit;
}

$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$password = $_POST['password'];

if(!file_exists($file)){
    file_put_contents($file, json_encode([])); //si le fichier n'existe pas on le cree avec [] comme contenu
}

$users = json_decode(file_get_contents($file), true);
if(!is_array($users)){
    $users = [];
}

foreach($users as $user){
    if($user['email'] === $email){
        header("LOcation: auth.php?error=exists&show=register");
        exit;
    }
}
$newUser = [
    "id" => count($users)+1,
    "nom" => $nom,
    "prenom" => $prenom,
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT)
];

$users[] = $newUser;
file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header("Location: auth.php?success=registered");
exit;

?>