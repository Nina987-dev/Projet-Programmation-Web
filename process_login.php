<?php
session_start();

$file = "users.json";
if(empty($_POST['email']) || empty($_POST['password'])){
    header("Location: auth.php?error=empty");
    exit;
}
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if(!file_exists($file)){
    header("Location: auth.php?error=invalid&show=register");
    exit;
}

$users = json_decode(file_get_contents($file), true);

if(!is_array($users)){
    $users = [];
}

foreach($users as $user){
    if($user['email'] === $email && password_verify($password, $user['password'])){
        $_SESSION['user'] = [
            "id" => $user['id'],
            "nom" => $user['nom'],
            "prenom" => $user['prenom'],
            "email" => $user['email']
        ];
        header ("Location: geopulse.php");
        exit;
    }
}
header("Location: auth.php?error=invalid&show=register");
exit;

?>