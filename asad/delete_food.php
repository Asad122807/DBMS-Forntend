<?php
require __DIR__ . '/db.php';
$id = $_POST['id'];
$stmt = $pdo->prepare("DELETE FROM food_inventory WHERE id=:id");
$success = $stmt->execute([':id'=>$id]);
echo json_encode(['success'=>$success]);
