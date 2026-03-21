<?php
require_once 'db_config.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT t.id, t.titre, t.description, t.valeur, t.url, s.nom AS source, t.date_publication 
            FROM tendances t 
            JOIN sources s ON t.source_id = s.id 
            ORDER BY t.date_publication DESC";
    
    $stmt = $pdo->query($sql);
    $tendances = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($tendances);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
