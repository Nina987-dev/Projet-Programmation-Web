<?php
require 'db_config.php';

if (isset($_GET['tendance_id'])) {
    $tendance_id = intval($_GET['tendance_id']);
    try {
        $stmt = $pdo->prepare("
            SELECT c.text, c.date_heure, u.name, u.first_name 
            FROM commentaires c 
            JOIN users u ON c.id_user = u.id 
            WHERE c.tendance_id = :tendance_id 
            ORDER BY c.date_heure DESC
        ");
        $stmt->execute(['tendance_id' => $tendance_id]);
        $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($commentaires);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erreur : " . $e->getMessage()]);
    }
} else {
    echo json_encode([]);
}
?>