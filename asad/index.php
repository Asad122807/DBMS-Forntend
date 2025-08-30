<?php
// index.php
require __DIR__ . '/db.php';


// Optional search (via GET ?q=)
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$params = [];
$sql = "SELECT id, name, species, age_years, gender, health_status, enclosure
        FROM tortoises";

if ($q !== '') {
    $sql .= " WHERE name LIKE :q OR species LIKE :q OR enclosure LIKE :q";
    $params[':q'] = "%{$q}%";
}

$sql .= " ORDER BY id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

$enclosureSql = "SELECT id, name, type, capacity, current_occupancy FROM enclosures ORDER BY id ASC";
$enclosureStmt = $pdo->prepare($enclosureSql);
$enclosureStmt->execute();
$enclosures = $enclosureStmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

$breedingSql = "SELECT br.id, fa.name AS female_name, ma.name AS male_name, br.species, 
                br.mating_date, br.nesting_date, br.egg_count, br.incubation_start, 
                br.incubation_period, br.hatch_date, br.hatching_success, br.observations
                FROM breeding_records br
                LEFT JOIN tortoises fa ON br.female_animal_id = fa.id
                LEFT JOIN tortoises ma ON br.male_animal_id = ma.id
                ORDER BY br.id ASC";
$breedingStmt = $pdo->prepare($breedingSql);
$breedingStmt->execute();
$breedingRecords = $breedingStmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

$feedingRecords = $pdo->query("
    SELECT f.id, f.feeding_time, f.food_type, f.quantity, f.status, f.observations,
           t.ID AS tortoise_id, t.name AS tortoise_name,
           s.name AS staff_name
    FROM feeding_details f
    LEFT JOIN tortoises t ON f.id = t.ID
    LEFT JOIN staff s ON f.staff_assigned = s.name
    ORDER BY f.id ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Fetch animals and staff for dropdowns
$animals = $pdo->query("SELECT ID, name FROM tortoises ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$staffs = $pdo->query("SELECT name FROM staff ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM food_inventory ORDER BY id ASC");
$foodItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

try {
    $stmt = $pdo->query("SELECT * FROM staff ORDER BY staff_id ASC");
    $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $staff = [];
    // optional: log the error
    // error_log($e->getMessage());
}

$stmt = $pdo->query("SELECT staff_id, name, age, title, join_date FROM staff");
$staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortoise Management System</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>
    <!-- Dashboard -->
    <div id="dashboard" class="dashboard">
        <!-- Navigation Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h2>Tortoise Care System</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="#" class="active-link" onclick="showContent('home-content')"><i>🏠</i> Home</a></li>
                <li><a href="#" onclick="showContent('tortoise-content')"><i>🐢</i> Tortoise Details</a></li>
                <li><a href="#" onclick="showContent('enclosure-content')"><i>🏡</i> Enclosure Details</a></li>
                <li><a href="#" onclick="showContent('surveillance-content')"><i>👁️</i> Surveillance</a></li>
                <li><a href="#" onclick="showContent('breeding-content')"><i>❤️</i> Breeding Details</a></li>
                <li><a href="#" onclick="showContent('feeding-content')"><i>🥗</i> Feeding Details</a></li>
                <li><a href="#" onclick="showContent('food-content')"><i>🍎</i> Food Inventory</a></li>
                <li><a href="#" onclick="showContent('documents-content')"><i>📄</i> Documents</a></li>
                <li><a href="#" onclick="showContent('staff-content')"><i>👥</i> Staff Members</a></li>
                <li><a href="#" onclick="showContent('about-content')"><i>ℹ️</i> About</a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <div class="header">
                <!-- Home Content -->
                <div id="home-content" class="container active">
                    <div class="content-header">
                        <h1>Dashboard Overview</h1>
                    </div>

                    <!-- Welcome Message -->
                    <p>Welcome to the Tortoise Management System. Use the navigation menu to access different sections.
                    </p>
                    <!-- Demo Information Section -->
                    <div class="demo-info">
                        <h3>About the Tortoise Project</h3>
                        <p>The Tortoise Management System is designed to monitor and manage tortoises in various
                            enclosures.
                            Our goal is to ensure the health, safety, and well-being of these animals while providing a
                            user-friendly
                            platform for caretakers to track their progress.</p>
                        <p><strong>Goals:</strong></p>
                        <ul>
                            <li>Track the health and status of tortoises in real-time.</li>
                            <li>Provide insights into species and enclosure management.</li>
                            <li>Ensure data-driven decisions for better care.</li>
                        </ul>
                    </div>

                    <!-- Video Section -->
                    <div class="video-section">
                        <h3>Learn More About Tortoise Care</h3>
                        <video width="900" autoplay loop muted>
                            <source src="img/StockFootage79.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>

                <!-- Tortoise Details Content -->
                <div id="tortoise-content" class="container">
                    <div class="content-header">
                        <h2>Tortoise Details</h2>
                        <button class="add-btn" onclick="openAddModal()">+ Add Tortoise</button>
                    </div>
                    <table id="tortoiseTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Species</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Health</th>
                                <th>Enclosure</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$rows): ?>
                                <tr>
                                    <td colspan="8" class="empty">No tortoises
                                        found<?php echo $q ? " for '" . htmlspecialchars($q, ENT_QUOTES) . "'" : ""; ?>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rows as $r): ?>
                                    <tr data-id="<?= $r['id']; ?>">
                                        <td><?= $r['id']; ?></td>
                                        <td><?= htmlspecialchars($r['name']); ?></td>
                                        <td><?= htmlspecialchars($r['species']); ?></td>
                                        <td><?= $r['age_years']; ?> years</td>
                                        <td><?= htmlspecialchars($r['gender']); ?></td>
                                        <td
                                            class="<?= $r['health_status'] === 'Healthy' ? 'status-active' : 'status-inactive'; ?>">
                                            <?= htmlspecialchars($r['health_status']); ?>
                                        </td>
                                        <td><?= htmlspecialchars($r['enclosure']); ?></td>
                                        <td>
                                            <button class="edit-btn" onclick="openEditModal(<?= $r['id']; ?>)">Edit</button>
                                            <button class="delete-btn"
                                                onclick="deleteTortoise(<?= $r['id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <p class="muted"><?= count($rows); ?> result(s).</p>
                </div>

                <!-- Add/Edit Modal -->
                <div id="modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <h2>Edit Tortoise</h2>
                        <form id="editForm" method="POST" action="update_tortoise.php">
                            <input type="hidden" id="tortoiseId" name="id">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                            <label for="species">Species:</label>
                            <select id="species" name="species" required>
                                <option value="Aldabra giant tortoise">Aldabra giant tortoise</option>
                                <option value="Galápagos giant tortoise">Galápagos giant tortoise</option>
                                <option value="Leopard tortoise">Leopard tortoise</option>
                                <option value="African spurred tortoise">African spurred tortoise</option>
                                <option value="Indian star tortoise">Indian star tortoise</option>
                                <option value="Burmese star tortoise">Burmese star tortoise</option>
                                <option value="Elongated tortoise">Elongated tortoise</option>
                                <option value="Travancore tortoise">Travancore tortoise</option>
                                <option value="Forsten’s tortoise">Forsten’s tortoise</option>
                                <option value="Russian tortoise">Russian tortoise</option>
                                <option value="Hermann’s tortoise">Hermann’s tortoise</option>
                                <option value="Greek tortoise">Greek tortoise</option>
                                <option value="Marginated tortoise">Marginated tortoise</option>
                                <option value="Egyptian tortoise">Egyptian tortoise</option>
                                <option value="Bolson tortoise">Bolson tortoise</option>
                                <option value="Texas tortoise">Texas tortoise</option>
                                <option value="Desert tortoise">Desert tortoise</option>
                                <option value="Sonoran desert tortoise">Sonoran desert tortoise</option>
                                <option value="Gopher tortoise">Gopher tortoise</option>
                                <option value="Pancake tortoise">Pancake tortoise</option>
                                <option value="Angulate tortoise">Angulate tortoise</option>
                                <option value="Speckled cape tortoise">Speckled cape tortoise</option>
                                <option value="Namaqualand speckled tortoise">Namaqualand speckled tortoise</option>
                                <option value="Karoo dwarf tortoise">Karoo dwarf tortoise</option>
                                <option value="Tent tortoise">Tent tortoise</option>
                                <option value="Serrated tortoise">Serrated tortoise</option>
                                <option value="Geometric tortoise">Geometric tortoise</option>
                                <option value="Yellow-footed tortoise">Yellow-footed tortoise</option>
                                <option value="Red-footed tortoise">Red-footed tortoise</option>
                                <option value="Chaco tortoise">Chaco tortoise</option>
                                <option value="Brazilian giant tortoise">Brazilian giant tortoise</option>
                                <option value="St Lucia giant tortoise (extinct)">St Lucia giant tortoise (extinct)
                                </option>
                                <option value="Pinta Island tortoise (extinct)">Pinta Island tortoise (extinct)</option>
                                <option value="Floreana Island tortoise (extinct)">Floreana Island tortoise (extinct)
                                </option>
                                <option value="Santa Cruz tortoise">Santa Cruz tortoise</option>
                                <option value="Isabela giant tortoise">Isabela giant tortoise</option>
                                <option value="Sierra Negra tortoise">Sierra Negra tortoise</option>
                                <option value="Española giant tortoise">Española giant tortoise</option>
                                <option value="San Cristóbal giant tortoise">San Cristóbal giant tortoise</option>
                                <option value="Pinzón tortoise">Pinzón tortoise</option>
                                <option value="Santiago tortoise">Santiago tortoise</option>
                            </select>
                            <label for="age">Age:</label>
                            <input type="number" id="age" name="age" required>
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <label for="health">Health:</label>
                            <select id="health" name="health" required>
                                <option value="Healthy">Healthy</option>
                                <option value="Sick">Sick</option>
                                <option value="Injured">Injured</option>
                            </select>
                            <label for="enclosure">Enclosure:</label>
                            <input type="text" id="enclosure" name="enclosure" required>
                            <button type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- Enclosure Details Content -->
                <div id="enclosure-content" class="container">
                    <div class="content-header">
                        <h2>Enclosure Details</h2>
                        <button class="add-btn" onclick="openEnclosureModal()">+ Add Enclosure</button>
                    </div>
                    <table id="enclosureTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Current Occupancy</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$enclosures): ?>
                                <tr>
                                    <td colspan="6" class="empty">No enclosures found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($enclosures as $enclosure): ?>
                                    <tr data-id="<?= $enclosure['id']; ?>">
                                        <td><?= $enclosure['id']; ?></td>
                                        <td><?= htmlspecialchars($enclosure['name']); ?></td>
                                        <td><?= htmlspecialchars($enclosure['type']); ?></td>
                                        <td><?= $enclosure['capacity']; ?></td>
                                        <td><?= $enclosure['current_occupancy']; ?></td>
                                        <td>
                                            <button class="edit-btn" onclick="openEditEnclosureModal(
                                            <?= $enclosure['id']; ?>,
        '                                   <?= htmlspecialchars($enclosure['name'], ENT_QUOTES); ?>',
        '                                   <?= htmlspecialchars($enclosure['type'], ENT_QUOTES); ?>',
                                            <?= $enclosure['capacity']; ?>,
                                            <?= $enclosure['current_occupancy']; ?>)">
                                                Edit
                                            </button>

                                            <button class="delete-btn"
                                                onclick="deleteEnclosure(<?= $enclosure['id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <p class="muted"><?= count($enclosures); ?> result(s).</p>
                </div>

                <!-- Add/Edit Enclosure Modal -->
                <div id="enclosure-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeEnclosureModal()">&times;</span>
                        <h2>Edit Enclosure</h2>
                        <form id="enclosureForm" method="POST" action="update_enclosure.php">
                            <input type="hidden" id="enclosureId" name="id">

                            <label for="enclosureName">Name:</label>
                            <input type="text" id="enclosureName" name="name" required readonly> <!-- locked name -->

                            <label for="enclosureType">Type:</label>
                            <input type="text" id="enclosureType" name="type" required>

                            <label for="capacity">Capacity:</label>
                            <input type="number" id="capacity" name="capacity" required>

                            <label for="currentOccupancy">Current Occupancy:</label>
                            <input type="number" id="currentOccupancy" name="current_occupancy" required>

                            <button type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- Breeding Details Content -->
                <div id="breeding-content" class="container">
                    <div class="content-header">
                        <h2>Breeding Details</h2>
                        <button class="add-btn" onclick="openBreedingModal()">+ Add Breeding Record</button>
                    </div>
                    <table id="breedingTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Female</th>
                                <th>Male</th>
                                <th>Species</th>
                                <th>Mating Date</th>
                                <th>Nesting Date</th>
                                <th>Egg Count</th>
                                <th>Incubation Start</th>
                                <th>Incubation Period</th>
                                <th>Hatch Date</th>
                                <th>Hatching Success (%)</th>
                                <th>Observations</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$breedingRecords): ?>
                                <tr>
                                    <td colspan="13" class="empty">No breeding records found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($breedingRecords as $br): ?>
                                    <tr data-id="<?= $br['id']; ?>">
                                        <td><?= $br['id']; ?></td>
                                        <td><?= htmlspecialchars($br['female_name']); ?></td>
                                        <td><?= htmlspecialchars($br['male_name']); ?></td>
                                        <td><?= htmlspecialchars($br['species']); ?></td>
                                        <td><?= $br['mating_date']; ?></td>
                                        <td><?= $br['nesting_date'] ?? '-'; ?></td>
                                        <td><?= $br['egg_count'] ?? '-'; ?></td>
                                        <td><?= $br['incubation_start'] ?? '-'; ?></td>
                                        <td><?= $br['incubation_period'] ?? '-'; ?></td>
                                        <td><?= $br['hatch_date'] ?? '-'; ?></td>
                                        <td><?= $br['hatching_success'] ?? '-'; ?></td>
                                        <td><?= htmlspecialchars($br['observations']); ?></td>
                                        <td>
                                            <button class="edit-btn"
                                                onclick="openEditBreedingModal(<?= $br['id']; ?>)">Edit</button>
                                            <button class="delete-btn"
                                                onclick="deleteBreedingRecord(<?= $br['id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <p class="muted"><?= count($breedingRecords); ?> result(s).</p>
                </div>

                <!-- Breeding Details Content -->
                <div id="breeding-content" class="container">
                    <div class="content-header">
                        <h2>Breeding Details</h2>
                        <button class="add-btn" onclick="openBreedingModal()">+ Add Breeding Record</button>
                    </div>
                    <table id="breedingTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Female</th>
                                <th>Male</th>
                                <th>Species</th>
                                <th>Mating Date</th>
                                <th>Nesting Date</th>
                                <th>Egg Count</th>
                                <th>Incubation Start</th>
                                <th>Incubation Period</th>
                                <th>Hatch Date</th>
                                <th>Hatching Success (%)</th>
                                <th>Observations</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$breedingRecords): ?>
                                <tr>
                                    <td colspan="13" class="empty">No breeding records found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($breedingRecords as $br): ?>
                                    <tr data-id="<?= $br['id']; ?>">
                                        <td><?= $br['id']; ?></td>
                                        <td><?= htmlspecialchars($br['female_name']); ?></td>
                                        <td><?= htmlspecialchars($br['male_name']); ?></td>
                                        <td><?= htmlspecialchars($br['species']); ?></td>
                                        <td><?= $br['mating_date']; ?></td>
                                        <td><?= $br['nesting_date'] ?? '-'; ?></td>
                                        <td><?= $br['egg_count'] ?? '-'; ?></td>
                                        <td><?= $br['incubation_start'] ?? '-'; ?></td>
                                        <td><?= $br['incubation_period'] ?? '-'; ?></td>
                                        <td><?= $br['hatch_date'] ?? '-'; ?></td>
                                        <td><?= $br['hatching_success'] ?? '-'; ?></td>
                                        <td><?= htmlspecialchars($br['observations']); ?></td>
                                        <td>
                                            <button class="edit-btn"
                                                onclick="openEditBreedingModal(<?= $br['id']; ?>)">Edit</button>
                                            <button class="delete-btn"
                                                onclick="deleteBreedingRecord(<?= $br['id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <p class="muted"><?= count($breedingRecords); ?> result(s).</p>
                </div>

                <!-- Add/Edit Breeding Modal -->
                <div id="breeding-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeBreedingModal()">&times;</span>
                        <h2>Add/Edit Breeding Record</h2>
                        <form id="breedingForm" method="POST" action="update_breeding.php">
                            <input type="hidden" id="breedingId" name="id">
                            <input type="hidden" id="species" name="species">

                            <label for="femaleAnimal">Female:</label>
                            <select id="femaleAnimal" name="female_animal_id" required>
                                <?php foreach ($rows as $r): ?>
                                    <?php if ($r['gender'] === 'Female'): ?>
                                        <option value="<?= $r['id']; ?>"><?= htmlspecialchars($r['name']); ?>
                                            (<?= htmlspecialchars($r['species']); ?>)</option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>

                            <label for="maleAnimal">Male:</label>
                            <select id="maleAnimal" name="male_animal_id" required>
                                <?php foreach ($rows as $r): ?>
                                    <?php if ($r['gender'] === 'Male'): ?>
                                        <option value="<?= $r['id']; ?>"><?= htmlspecialchars($r['name']); ?>
                                            (<?= htmlspecialchars($r['species']); ?>)</option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>

                            <label for="matingDate">Mating Date:</label>
                            <input type="date" id="matingDate" name="mating_date" required>

                            <label for="nestingDate">Nesting Date:</label>
                            <input type="date" id="nestingDate" name="nesting_date">

                            <label for="eggCount">Egg Count:</label>
                            <input type="number" id="eggCount" name="egg_count">

                            <label for="incubationStart">Incubation Start:</label>
                            <input type="date" id="incubationStart" name="incubation_start">

                            <label for="incubationPeriod">Incubation Period (days):</label>
                            <input type="number" id="incubationPeriod" name="incubation_period">

                            <label for="hatchDate">Hatch Date:</label>
                            <input type="date" id="hatchDate" name="hatch_date">

                            <label for="hatchingSuccess">Hatching Success (%):</label>
                            <input type="number" step="0.01" id="hatchingSuccess" name="hatching_success">

                            <label for="observations">Observations:</label>
                            <textarea id="observations" name="observations"></textarea>

                            <button type="submit">Save Record</button>
                        </form>
                    </div>
                </div>

                <!-- Surveillance Table -->
                <div id="surveillance-content" class="container">
                    <div class="content-header">
                        <h2>Enclosure Surveillance</h2>
                        <button class="add-btn" onclick="openSurveillanceModal()">+ Add Surveillance Record</button>
                    </div>
                    <table id="surveillanceTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Enclosure</th>
                                <th>Size</th>
                                <th>Habitat Type</th>
                                <th>Current Occupants</th>
                                <th>Maintenance Schedule</th>
                                <th>Temp (°C)</th>
                                <th>Humidity (%)</th>
                                <th>Light Level</th>
                                <th>Observations</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("
                SELECT s.*, e.name AS enclosure_name
                FROM surveillance s
                JOIN enclosures e ON s.enclosure_id = e.id
                ORDER BY s.id ASC
            ");
                            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (!$records):
                                ?>
                                <tr>
                                    <td colspan="11" class="empty">No surveillance records found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($records as $s): ?>
                                    <tr data-id="<?= $s['id'] ?>">
                                        <td><?= $s['id'] ?></td>
                                        <td><?= htmlspecialchars($s['enclosure_name']) ?></td>
                                        <td><?= htmlspecialchars($s['size']) ?></td>
                                        <td><?= htmlspecialchars($s['habitat_type']) ?></td>
                                        <td><?= htmlspecialchars($s['current_occupants']) ?></td>
                                        <td><?= htmlspecialchars($s['maintenance_schedule']) ?></td>
                                        <td><?= $s['temperature'] ?></td>
                                        <td><?= $s['humidity'] ?></td>
                                        <td><?= htmlspecialchars($s['light_level']) ?></td>
                                        <td><?= htmlspecialchars($s['observations']) ?></td>
                                        <td>
                                            <button class="edit-btn" onclick="
                                openSurveillanceModal(
                                    '<?= $s['id'] ?>',
                                    '<?= $s['enclosure_id'] ?>',
                                    '<?= htmlspecialchars($s['size'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($s['habitat_type'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($s['current_occupants'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($s['maintenance_schedule'], ENT_QUOTES) ?>',
                                    '<?= $s['temperature'] ?>',
                                    '<?= $s['humidity'] ?>',
                                    '<?= htmlspecialchars($s['light_level'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($s['observations'], ENT_QUOTES) ?>'
                                )">Edit</button>
                                            <button class="delete-btn"
                                                onclick="deleteSurveillance(<?= $s['id'] ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Add/Edit Surveillance Modal -->
                <div id="surveillance-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeSurveillanceModal()">&times;</span>
                        <h2>Add/Edit Surveillance Record</h2>
                        <form id="surveillanceForm" method="POST" action="update_surveillance.php">
                            <input type="hidden" id="survId" name="id">

                            <label for="enclosureSelect">Enclosure:</label>
                            <select id="enclosureSelect" name="enclosure_id" required>
                                <option value="">Select Enclosure</option>
                                <?php foreach ($enclosures as $e): ?>
                                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['name']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="size">Size:</label>
                            <input type="text" id="size" name="size" required>

                            <label for="habitat_type">Habitat Type:</label>
                            <input type="text" id="habitat_type" name="habitat_type" required>

                            <label for="current_occupants">Current Occupants (comma-separated):</label>
                            <input type="text" id="current_occupants" name="current_occupants" required>

                            <label for="maintenance_schedule">Maintenance Schedule:</label>
                            <input type="text" id="maintenance_schedule" name="maintenance_schedule" required>

                            <label for="temperature">Temperature (°C):</label>
                            <input type="number" step="0.1" id="temperature" name="temperature">

                            <label for="humidity">Humidity (%):</label>
                            <input type="number" step="0.1" id="humidity" name="humidity">

                            <label for="light_level">Light Level:</label>
                            <select id="light_level" name="light_level">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>

                            <label for="observations">Observations:</label>
                            <textarea id="observations" name="observations"></textarea>

                            <button type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Feeding Details Content -->
            <div id="feeding-content" class="container">
                <div class="content-header">
                    <h2>Feeding Records</h2>
                    <button class="add-btn" onclick="openFeedingModal()">+ Add Feeding Record</button>
                </div>

                <table id="feedingTable" border="1">
                    <thead>
                        <tr>
                            <th>ID (Tortoise)</th>
                            <th>Tortoise Name</th>
                            <th>Staff Assigned</th>
                            <th>Feeding Time</th>
                            <th>Food Type</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Observations</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$feedingRecords): ?>
                            <tr>
                                <td colspan="9" class="empty">No feeding records found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($feedingRecords as $f): ?>
                                <tr data-id="<?= $f['id'] ?>">
                                    <td><?= $f['tortoise_id'] ?></td>
                                    <td><?= htmlspecialchars($f['tortoise_name']) ?></td>
                                    <td><?= htmlspecialchars($f['staff_name']) ?></td>
                                    <td><?= htmlspecialchars($f['feeding_time']) ?></td>
                                    <td><?= htmlspecialchars($f['food_type']) ?></td>
                                    <td><?= htmlspecialchars($f['quantity']) ?></td>
                                    <td><?= htmlspecialchars($f['status']) ?></td>
                                    <td><?= htmlspecialchars($f['observations']) ?></td>
                                    <td>
                                        <button onclick="openFeedingModal(
                                '<?= $f['id'] ?>',
                                '<?= $f['tortoise_id'] ?>',
                                '<?= $f['staff_name'] ?>',
                                '<?= $f['feeding_time'] ?>',
                                '<?= $f['food_type'] ?>',
                                '<?= $f['quantity'] ?>',
                                '<?= $f['status'] ?>',
                                '<?= $f['observations'] ?>'
                            )">Edit</button>
                                        <button onclick="deleteFeeding(<?= $f['id'] ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p class="muted"><?= count($feedingRecords); ?> result(s).</p>
            </div>

            <!-- Feeding Modal (leave global, outside container) -->
            <div id="feeding-modal" class="modal hidden">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeFeedingModal()">&times;</span>
                    <h2>Add/Edit Feeding Record</h2>
                    <form id="feedingForm" method="POST" action="update_feeding.php">
                        <input type="hidden" id="feedingId" name="id">

                        <label for="tortoiseSelect">Tortoise:</label>
                        <select id="tortoiseSelect" name="id" required>
                            <option value="">Select Tortoise</option>
                            <?php foreach ($animals as $a): ?>
                                <option value="<?= $a['ID'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="staffSelect">Staff Assigned:</label>
                        <select id="staffSelect" name="staff_assigned" required>
                            <option value="">Select Staff</option>
                            <?php foreach ($staffs as $s): ?>
                                <option value="<?= htmlspecialchars($s['name']) ?>"><?= htmlspecialchars($s['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="feedingTime">Feeding Time:</label>
                        <input type="datetime-local" id="feedingTime" name="feeding_time" required>

                        <label for="foodType">Food Type:</label>
                        <input type="text" id="foodType" name="food_type" required>

                        <label for="quantity">Quantity:</label>
                        <input type="text" id="quantity" name="quantity" required>

                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="Completed">Completed</option>
                            <option value="Pending">Pending</option>
                        </select>

                        <label for="observations">Observations:</label>
                        <textarea id="observations" name="observations"></textarea>

                        <button type="submit">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Food Inventory Content -->
            <div id="food-content" class="container">
                <div class="content-header">
                    <h2>Food Inventory</h2>
                    <button class="add-btn" onclick="openFoodModal()">+ Add Food Item</button>
                </div>

                <table id="foodTable" border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Food Item</th>
                            <th>Quantity</th>
                            <th>Added At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$foodItems): ?>
                            <tr>
                                <td colspan="5" class="empty">No food items found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($foodItems as $f): ?>
                                <tr data-id="<?= $f['id'] ?>">
                                    <td><?= $f['id'] ?></td>
                                    <td><?= htmlspecialchars($f['food_item']) ?></td>
                                    <td><?= htmlspecialchars($f['quantity']) ?></td>
                                    <td><?= htmlspecialchars($f['added_at']) ?></td>
                                    <td>
                                        <button onclick="openFoodModal(
                                '<?= $f['id'] ?>',
                                '<?= htmlspecialchars($f['food_item']) ?>',
                                '<?= $f['quantity'] ?>'
                            )">Edit</button>
                                        <button onclick="deleteFood(<?= $f['id'] ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p class="muted"><?= count($foodItems); ?> result(s).</p>
            </div>

            <!-- Food Modal (with added_at) -->
            <div id="food-modal" class="modal hidden">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeFoodModal()">&times;</span>
                    <h2>Add/Edit Food Item</h2>
                    <form id="foodForm" method="POST" action="update_food.php">
                        <input type="hidden" id="foodId" name="id">

                        <label for="foodName">Food Item:</label>
                        <input type="text" id="foodName" name="food_item" required>

                        <label for="foodQuantity">Quantity:</label>
                        <input type="number" id="foodQuantity" name="quantity" required>

                        <label for="addedAt">Added At:</label>
                        <input type="datetime-local" id="addedAt" name="added_at">

                        <button type="submit">Save Changes</button>
                    </form>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

            <!-- Documents / Reports -->
            <div id="documents-content" class="container">
                <div class="content-header">
                    <h2>Generate Reports</h2>
                    <button class="report-btn" onclick="generateReport('tortoises')">Tortoise Health Report</button>
                    <button class="report-btn" onclick="generateReport('food_inventory')">Food Inventory Report</button>
                    <button class="report-btn" onclick="generateReport('breeding_records')">Breeding Report</button>
                    <button class="report-btn" onclick="generateReport('feeding_details')">Feeding Report</button>
                </div>
                <div id="report-status" class="muted"></div>
            </div>

            <!-- Staff Content -->
            <div id="staff-content" class="container">
                <div class="content-header">
                    <h2>Staff Management</h2>
                    <button class="add-btn" onclick="openStaffModal()">+ Add Staff</button>
                </div>

                <table id="staffTable" border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Title</th>
                            <th>Join Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$staffs): ?>
                            <tr>
                                <td colspan="6" class="empty">No staff found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($staffs as $s): ?>
                                <tr data-id="<?= $s['staff_id'] ?>">
                                    <td><?= $s['staff_id'] ?></td>
                                    <td><?= htmlspecialchars($s['name']) ?></td>
                                    <td><?= htmlspecialchars($s['age']) ?></td>
                                    <td><?= htmlspecialchars($s['title']) ?></td>
                                    <td><?= htmlspecialchars($s['join_date']) ?></td>
                                    <td>
                                        <button onclick="openStaffModal(
                                '<?= $s['staff_id'] ?>',
                                '<?= htmlspecialchars($s['name'], ENT_QUOTES) ?>',
                                '<?= $s['age'] ?>',
                                '<?= htmlspecialchars($s['title'], ENT_QUOTES) ?>',
                                '<?= $s['join_date'] ?>'
                            )">Edit</button>
                                        <button onclick="deleteStaff(<?= $s['staff_id'] ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p class="muted"><?= count($staffs); ?> result(s).</p>
            </div>

            <!-- Staff Modal -->
            <div id="staff-modal" class="modal hidden">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeStaffModal()">&times;</span>
                    <h2>Add/Edit Staff</h2>
                    <form id="staffForm" method="POST" action="update_staff.php">
                        <input type="hidden" id="staffId" name="staff_id">

                        <label for="staffName">Name:</label>
                        <input type="text" id="staffName" name="name" required>

                        <label for="staffAge">Age:</label>
                        <input type="number" id="staffAge" name="age" required>

                        <label for="staffTitle">Title:</label>
                        <input type="text" id="staffTitle" name="title" required>

                        <label for="staffJoinDate">Join Date:</label>
                        <input type="date" id="staffJoinDate" name="join_date" required>

                        <button type="submit">Save Changes</button>
                    </form>
                </div>
            </div>

            <script>
                // Open Add Staff Modal
                function openStaffModal(id = '', name = '', age = '', title = '', join_date = '') {
                    document.getElementById('staffId').value = id;
                    document.getElementById('staffName').value = name;
                    document.getElementById('staffAge').value = age;
                    document.getElementById('staffTitle').value = title;
                    document.getElementById('staffJoinDate').value = join_date;
                    document.getElementById('staff-modal').classList.remove('hidden');
                }

                function closeStaffModal() {
                    document.getElementById('staff-modal').classList.add('hidden');
                }

                // Delete staff
                function deleteStaff(id) {
                    if (confirm('Are you sure you want to delete this staff?')) {
                        window.location = 'update_staff.php?delete=' + id;
                    }
                }
            </script>

            <div id="about-content" class="container active">
                <div class="content-header">
                    <h1>About Us</h1>
                </div>

                <!-- About Us Message -->
                <p>Welcome to the Tortoise Management System. Our platform is dedicated to providing a reliable and
                    user-friendly system for monitoring and managing tortoises in various enclosures.</p>

                <div class="demo-info">
                    <h3>Our Mission</h3>
                    <p>We strive to ensure the health, safety, and well-being of tortoises while supporting caretakers
                        with accurate and accessible data.</p>

                    <p><strong>Objectives:</strong></p>
                    <ul>
                        <li>Track tortoise health and enclosure conditions efficiently.</li>
                        <li>Manage species, age, and occupancy data effectively.</li>
                        <li>Enable informed decisions for optimal care and management.</li>
                    </ul>
                </div>
            </div>




</body>

</html>