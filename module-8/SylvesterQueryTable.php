<?php
/**
 * Script: SylvesterQueryTable.php
 * Purpose: Query and display all records from 'baseball_stats' in an HTML table.
 * Author: Sylvester
 * Date: April 27, 2026
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'student1';
$password = 'pass';
$database = 'baseball_01';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

$tableName = "baseball_stats";
$output = "";
$error = false;
$rowCount = 0;

// Check if table exists
$check = $conn->query("SHOW TABLES LIKE '$tableName'");
if ($check->num_rows == 0) {
    $error = true;
    $output = "<p style='color:red;'>Table '$tableName' does not exist. Please run <strong>SylvesterCreateTable.php</strong> and then <strong>SylvesterPopulateTable.php</strong>.</p>";
} else {
    // Retrieve all data
    $result = $conn->query("SELECT id, player_name, team, position, home_runs, batting_avg FROM $tableName ORDER BY home_runs DESC");
    if ($result) {
        $rowCount = $result->num_rows;
        if ($rowCount > 0) {
            $output = "<table>
                            <tr>
                                <th>ID</th>
                                <th>Player Name</th>
                                <th>Team</th>
                                <th>Position</th>
                                <th>Home Runs</th>
                                <th>Batting Avg</th>
                            </tr>";
            while ($row = $result->fetch_assoc()) {
                $output .= "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['player_name']) . "</td>
                                <td>" . htmlspecialchars($row['team']) . "</td>
                                <td>" . htmlspecialchars($row['position']) . "</td>
                                <td>" . htmlspecialchars($row['home_runs']) . "</td>
                                <td>" . htmlspecialchars($row['batting_avg']) . "</td>
                            </tr>";
            }
            $output .= "</table>";
        } else {
            $output = "<p>No records found. Please populate the table using <strong>SylvesterPopulateTable.php</strong> first.</p>";
        }
        $result->free();
    } else {
        $error = true;
        $output = "<p style='color:red;'>Query failed: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Baseball Stats - Query Results</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 8px; overflow-x: auto; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .count { font-weight: bold; margin-top: 15px; }
        .nav { margin-top: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; background: #007BFF; color: white; padding: 5px 10px; border-radius: 4px; }
        .nav a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Baseball Player Stats</h1>
        <?php if (!$error && $rowCount > 0): ?>
            <?php echo $output; ?>
            <div class="count">Total records: <?php echo $rowCount; ?></div>
        <?php else: ?>
            <?php echo $output; ?>
        <?php endif; ?>
        <div class="nav">
            <a href="SylvesterCreateTable.php">Create Table</a>
            <a href="SylvesterPopulateTable.php">Populate Table</a>
            <a href="SylvesterDropTable.php">Drop Table</a>
        </div>
    </div>
</body>
</html>