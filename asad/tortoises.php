<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Tortoises</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>🐢 Tortoises</h2>
  <a href="index.php">⬅ Back</a>
  
  <table>
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
    <?php
    $result = $conn->query("SELECT * FROM tortoises");
    while($row = $result->fetch_assoc()) {
      echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['species']}</td>
              <td>{$row['age_years']}</td>
              <td>{$row['gender']}</td>
              <td>{$row['health_status']}</td>
              <td>{$row['enclosure']}</td>
              <td>
                <button>Edit</button>
                <button>Delete</button>
              </td>
            </tr>";
    }
    ?>
  </table>
</body>
</html>
