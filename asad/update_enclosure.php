<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $current_occupancy = $_POST['current_occupancy'];

    if (empty($id)) {
        // Add new tortoise
        $stmt = $pdo->prepare("INSERT INTO enclosures (name, type, capacity, current_occupancy) VALUES (:name, :type, :capacity, :current_occupancy)");
        $stmt->execute([
            ':name' => $name,
            ':type' => $type,
            ':capacity' => $capacity,
            ':current_occupancy' => $current_occupancy,
        ]);
    } else {
        // Update existing tortoise
        $stmt = $pdo->prepare("UPDATE enclosures SET name = :name, type = :type, capacity = :capacity, current_occupancy = :current_occupancy WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':type' => $type,
            ':capacity' => $capacity,
            ':current_occupancy' => $current_occupancy,
        ]);
    }

    header('Location: index.php');
    exit;
}
?>