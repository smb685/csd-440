<?php
/**
 * Script: SylvesterPopulateTable.php
 * Purpose: Insert sample baseball player records into 'baseball_stats'.
 * Clears existing data first to avoid duplicates.
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

// First, verify table exists
$checkTable = $conn->query("SHOW TABLES LIKE '$tableName'");
if ($checkTable->num_rows == 0) {
    $errorMsg = "<p style='color:red;'>Table '$tableName' does not exist. Please run <strong>SylvesterCreateTable.php</strong> first.</p>";
    $conn->close();
    displayMessage($errorMsg);
    exit;
}

// Clear existing data (optional – keeps table clean)
$conn->query("DELETE FROM $tableName");
// Reset auto increment (optional)
$conn->query("ALTER TABLE $tableName AUTO_INCREMENT = 1");

// Sample data: player_name, team, position, home_runs, batting_avg
$players = [
    ['Babe Ruth', 'New York Yankees', 'OF', 714, 0.342],
    ['Hank Aaron', 'Atlanta Braves', 'OF', 755, 0.305],
    ['Barry Bonds', 'San Francisco Giants', 'OF', 762, 0.298],
    ['Ted Williams', 'Boston Red Sox', 'OF', 521, 0.344],
    ['Willie Mays', 'San Francisco Giants', 'CF', 660, 0.302],
    ['Mike Trout', 'Los Angeles Angels', 'CF', 350, 0.301]
];

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO $tableName (player_name, team, position, home_runs, batting_avg) VALUES (?, ?, ?, ?, ?)");
$insertCount = 0;

foreach ($players as $player) {
    $stmt->bind_param("sssid", $player[0], $player[1], $player[2], $player[3], $player[4]);
    if ($stmt->execute()) {
        $insertCount++;
    }
}
$stmt->close();
$conn->close();

$message = "<p style='color:green;'>Successfully inserted $insertCount record(s) into '$tableName'.</p>";

function displayMessage($msg) {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head><meta charset="UTF-8"><title>Populate Table</title>
    <style>body{font-family:Arial;margin:40px;background:#f4f4f4;}.container{max-width:700px;margin:auto;background:white;padding:20px;border-radius:8px;}</style>
    </head>
    <body><div class="container">$msg</div></body>
    </html>
HTML;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Populate Baseball Stats</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 700px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Populate baseball_stats Table</h1>
        <?php echo $message; ?>
        <h2>Inserted Records Preview (first 5 shown)</h2>
        <?php
        // Reconnect to show inserted data
        $conn2 = new mysqli($host, $user, $password, $database);
        $result = $conn2->query("SELECT id, player_name, team, position, home_runs, batting_avg FROM $tableName LIMIT 5");
        if ($result && $result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Player</th><th>Team</th><th>Pos</th><th>HR</th><th>Avg</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['player_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['team']) . "</td>";
                echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                echo "<td>" . htmlspecialchars($row['home_runs']) . "</td>";
                echo "<td>" . htmlspecialchars($row['batting_avg']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<p><a href='SylvesterQueryTable.php'>View Full Table →</a> | <a href='SylvesterIndex.php'>Home</a></p>";
        } else {
            echo "<p>No records found. Something went wrong.</p>";
        }
        $conn2->close();
        ?>
        <p><a href="SylvesterCreateTable.php">Create Table</a> | <a href="SylvesterDropTable.php">Drop Table</a></p>
    </div>
</body>
</html>