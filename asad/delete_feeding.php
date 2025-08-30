<?php
require __DIR__ . '/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM feeding_details WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header('Location: index.php#feeding-content');
exit;
?>
