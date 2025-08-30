<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $female_animal_id = $_POST['female_animal_id'];
    $male_animal_id = $_POST['male_animal_id'];
    $species = $_POST['species'];
    $mating_date = $_POST['mating_date'];
    $nesting_date = $_POST['nesting_date'] ?: null;
    $egg_count = $_POST['egg_count'] ?: null;
    $incubation_start = $_POST['incubation_start'] ?: null;
    $incubation_period = $_POST['incubation_period'] ?: null;
    $hatch_date = $_POST['hatch_date'] ?: null;
    $hatching_success = $_POST['hatching_success'] ?: null;
    $observations = $_POST['observations'] ?: null;

    if (empty($id)) {
        // Add new breeding record
        $stmt = $pdo->prepare("
            INSERT INTO breeding_records 
            (female_animal_id, male_animal_id, species, mating_date, nesting_date, egg_count, incubation_start, incubation_period, hatch_date, hatching_success, observations) 
            VALUES 
            (:female_animal_id, :male_animal_id, :species, :mating_date, :nesting_date, :egg_count, :incubation_start, :incubation_period, :hatch_date, :hatching_success, :observations)
        ");
        $stmt->execute([
            ':female_animal_id' => $female_animal_id,
            ':male_animal_id' => $male_animal_id,
            ':species' => $species,
            ':mating_date' => $mating_date,
            ':nesting_date' => $nesting_date,
            ':egg_count' => $egg_count,
            ':incubation_start' => $incubation_start,
            ':incubation_period' => $incubation_period,
            ':hatch_date' => $hatch_date,
            ':hatching_success' => $hatching_success,
            ':observations' => $observations,
        ]);
    } else {
        // Update existing breeding record
        $stmt = $pdo->prepare("
            UPDATE breeding_records SET 
            female_animal_id = :female_animal_id,
            male_animal_id = :male_animal_id,
            species = :species,
            mating_date = :mating_date,
            nesting_date = :nesting_date,
            egg_count = :egg_count,
            incubation_start = :incubation_start,
            incubation_period = :incubation_period,
            hatch_date = :hatch_date,
            hatching_success = :hatching_success,
            observations = :observations
            WHERE id = :id
        ");
        $stmt->execute([
            ':id' => $id,
            ':female_animal_id' => $female_animal_id,
            ':male_animal_id' => $male_animal_id,
            ':species' => $species,
            ':mating_date' => $mating_date,
            ':nesting_date' => $nesting_date,
            ':egg_count' => $egg_count,
            ':incubation_start' => $incubation_start,
            ':incubation_period' => $incubation_period,
            ':hatch_date' => $hatch_date,
            ':hatching_success' => $hatching_success,
            ':observations' => $observations,
        ]);
    }

    header('Location: index.php');
    exit;
}
?>
