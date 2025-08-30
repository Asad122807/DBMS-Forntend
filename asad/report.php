<?php
require __DIR__ . '/db.php';

$report = $_GET['report'] ?? '';

switch ($report) {
    case 'tortoises':
        $stmt = $pdo->query("SELECT id, name, species, age_years, gender, health_status, enclosure FROM tortoises");
        break;
    case 'food_inventory':
        $stmt = $pdo->query("SELECT id, food_item, quantity, added_at FROM food_inventory");
        break;
    case 'breeding_records':
        $stmt = $pdo->query("SELECT id, female_animal_id, male_animal_id, species, mating_date, egg_count, hatching_success FROM breeding_records");
        break;
    case 'feeding_details':
        $stmt = $pdo->query("SELECT id, staff_assigned, feeding_time, food_type, quantity, status, observations FROM feeding_details");
        break;
    default:
        echo json_encode([]);
        exit;
}

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($data);
