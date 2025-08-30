<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $health = $_POST['health'];
    $enclosure = $_POST['enclosure'];

    if (empty($id)) {
        // Add new tortoise
        $stmt = $pdo->prepare("INSERT INTO tortoises (name, species, age_years, gender, health_status, enclosure) 
                               VALUES (:name, :species, :age, :gender, :health, :enclosure)");
        $stmt->execute([
            ':name' => $name,
            ':species' => $species,
            ':age' => $age,
            ':gender' => $gender,
            ':health' => $health,
            ':enclosure' => $enclosure
        ]);
    } else {
        // Update existing tortoise
        $stmt = $pdo->prepare("UPDATE tortoises 
                               SET name = :name, species = :species, age_years = :age, gender = :gender, health_status = :health, enclosure = :enclosure 
                               WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':species' => $species,
            ':age' => $age,
            ':gender' => $gender,
            ':health' => $health,
            ':enclosure' => $enclosure
        ]);
    }

    // 🔄 Auto-Sync Enclosures Table
    try {
        $stmt = $pdo->query("
            SELECT enclosure AS name, COUNT(*) AS occupancy
            FROM tortoises
            GROUP BY enclosure
        ");
        $tortoiseEnclosures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tortoiseEnclosures as $enc) {
            $name = $enc['name'];
            $occupancy = $enc['occupancy'];

            // Check if enclosure exists
            $check = $pdo->prepare("SELECT id FROM enclosures WHERE name = :name");
            $check->execute([':name' => $name]);
            $exists = $check->fetch();

            if ($exists) {
                // Update occupancy
                $update = $pdo->prepare("UPDATE enclosures 
                                         SET current_occupancy = :occ, updated_at = NOW() 
                                         WHERE name = :name");
                $update->execute([':occ' => $occupancy, ':name' => $name]);
            } else {
                // Insert new enclosure with defaults
                $insert = $pdo->prepare("INSERT INTO enclosures (name, type, capacity, current_occupancy, created_at, updated_at) 
                                         VALUES (:name, 'General', 10, :occ, NOW(), NOW())");
                $insert->execute([':name' => $name, ':occ' => $occupancy]);
            }
        }
    } catch (Exception $e) {
        // optional: log error instead of stopping
        error_log("Enclosure sync failed: " . $e->getMessage());
    }

    header('Location: index.php');
    exit;
}
?>
