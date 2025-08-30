<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $enclosure_id = $_POST['enclosure_id'];
    $size = $_POST['size'];
    $habitat_type = $_POST['habitat_type'];
    $current_occupants = $_POST['current_occupants'];
    $maintenance_schedule = $_POST['maintenance_schedule'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $light_level = $_POST['light_level'];
    $observations = $_POST['observations'];

    if (empty($id)) {
        // INSERT new record
        $stmt = $pdo->prepare("
            INSERT INTO surveillance
            (enclosure_id, size, habitat_type, current_occupants, maintenance_schedule, temperature, humidity, light_level, observations, created_at, updated_at)
            VALUES
            (:enclosure_id, :size, :habitat_type, :current_occupants, :maintenance_schedule, :temperature, :humidity, :light_level, :observations, NOW(), NOW())
        ");

        $stmt->execute([
            ':enclosure_id' => $enclosure_id,
            ':size' => $size,
            ':habitat_type' => $habitat_type,
            ':current_occupants' => $current_occupants,
            ':maintenance_schedule' => $maintenance_schedule,
            ':temperature' => $temperature,
            ':humidity' => $humidity,
            ':light_level' => $light_level,
            ':observations' => $observations
        ]);

    } else {
        // UPDATE existing record
        $stmt = $pdo->prepare("
            UPDATE surveillance SET
                enclosure_id = :enclosure_id,
                size = :size,
                habitat_type = :habitat_type,
                current_occupants = :current_occupants,
                maintenance_schedule = :maintenance_schedule,
                temperature = :temperature,
                humidity = :humidity,
                light_level = :light_level,
                observations = :observations,
                updated_at = NOW()
            WHERE id = :id
        ");

        $stmt->execute([
            ':enclosure_id' => $enclosure_id,
            ':size' => $size,
            ':habitat_type' => $habitat_type,
            ':current_occupants' => $current_occupants,
            ':maintenance_schedule' => $maintenance_schedule,
            ':temperature' => $temperature,
            ':humidity' => $humidity,
            ':light_level' => $light_level,
            ':observations' => $observations,
            ':id' => $id  // <-- include :id here!
        ]);
    }

    header('Location: index.php');
    exit;
}
