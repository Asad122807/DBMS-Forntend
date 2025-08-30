<?php
require __DIR__ . '/db.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT 
        e.capacity AS size,
        e.type,
        GROUP_CONCAT(t.name SEPARATOR ', ') AS current_occupants
    FROM enclosures e
    LEFT JOIN tortoises t ON t.enclosure = e.name
    WHERE e.id = :id
    GROUP BY e.id
");
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data ?: ['size'=>'','type'=>'','current_occupants'=>'']);
