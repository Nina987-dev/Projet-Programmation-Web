<?php
require_once 'db_config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!empty($data['text']) && !empty($data['tendance_id']) && !empty($data['id_user'])) {
        $sql = "INSERT INTO commentaires (text, tendance_id, id_user) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$data['text'], $data['tendance_id'], $data['id_user']]);
        
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Données incomplètes"]);
    }
}
?>