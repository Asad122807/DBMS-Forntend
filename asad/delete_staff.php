<?php
require 'db.php'; // include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $id = intval($_POST['staff_id']);

    // Delete staff record
    $stmt = $pdo->prepare("DELETE FROM staff WHERE staff_id = ?");
    $success = $stmt->execute([$id]);

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Staff deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete staff']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
