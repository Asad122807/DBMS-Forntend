<?php
require 'db.php'; // include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';
    $name = trim($_POST['name']);
    $age = intval($_POST['age']);
    $title = trim($_POST['title']);
    $join_date = $_POST['join_date'];

    if ($id) {
        // Update existing staff
        $stmt = $pdo->prepare("UPDATE staff SET name = ?, age = ?, title = ?, join_date = ? WHERE staff_id = ?");
        $stmt->execute([$name, $age, $title, $join_date, $id]);
        header('Location: index.php'); // redirect back
        exit;
    } else {
        // Add new staff
        $stmt = $pdo->prepare("INSERT INTO staff (name, age, title, join_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $age, $title, $join_date]);
        header('Location: index.php'); // redirect back
        exit;
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM staff WHERE staff_id = ?");
    $stmt->execute([$id]);
    header('Location: index.php'); // redirect back
    exit;
}
?>
