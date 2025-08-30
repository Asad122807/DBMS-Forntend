<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // This is tortoise ID, also primary key in feeding_details
    $staff_assigned = $_POST['staff_assigned'];
    $feeding_time = $_POST['feeding_time'];
    $food_type = $_POST['food_type'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $observations = $_POST['observations'];

    // Check if record exists
    $check = $pdo->prepare("SELECT * FROM feeding_details WHERE id = :id");
    $check->execute([':id' => $id]);
    $exists = $check->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        // Update
        $stmt = $pdo->prepare("
            UPDATE feeding_details SET
                staff_assigned = :staff_assigned,
                feeding_time = :feeding_time,
                food_type = :food_type,
                quantity = :quantity,
                status = :status,
                observations = :observations
            WHERE id = :id
        ");
    } else {
        // Insert
        $stmt = $pdo->prepare("
            INSERT INTO feeding_details
            (id, staff_assigned, feeding_time, food_type, quantity, status, observations)
            VALUES
            (:id, :staff_assigned, :feeding_time, :food_type, :quantity, :status, :observations)
        ");
    }

    $stmt->execute([
        ':id' => $id,
        ':staff_assigned' => $staff_assigned,
        ':feeding_time' => $feeding_time,
        ':food_type' => $food_type,
        ':quantity' => $quantity,
        ':status' => $status,
        ':observations' => $observations
    ]);

    header('Location: index.php#feeding-content');
    exit;    
}
