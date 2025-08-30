<?php
// Include the database connection
require __DIR__ . '/db.php';

// Now $pdo is available
$id = $_POST['id'] ?? '';
$food_item = $_POST['food_item'];
$quantity = $_POST['quantity'];
$added_at = $_POST['added_at'] ?? null;

if ($id) {
    // Update existing record
    $stmt = $pdo->prepare("UPDATE food_inventory 
        SET food_item = :food_item, 
            quantity = :quantity, 
            added_at = COALESCE(:added_at, added_at) 
        WHERE id = :id");
    $stmt->execute([
        ':food_item' => $food_item,
        ':quantity' => $quantity,
        ':added_at' => $added_at ?: null,
        ':id' => $id
    ]);
} else {
    // Insert new record
    $stmt = $pdo->prepare("INSERT INTO food_inventory (food_item, quantity, added_at) 
        VALUES (:food_item, :quantity, COALESCE(:added_at, NOW()))");
    $stmt->execute([
        ':food_item' => $food_item,
        ':quantity' => $quantity,
        ':added_at' => $added_at ?: null
    ]);
}

// Redirect back to food inventory page
header('Location: index.php');
exit;
