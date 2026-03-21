<?php
$host = "localhost";
$port = "5432";
$dbname = "geopulse_db";
$user = "postgres";
$password = "root";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die(json_encode(["error" => "Erreur de connexion : " . $e->getMessage()]));
}
?>
