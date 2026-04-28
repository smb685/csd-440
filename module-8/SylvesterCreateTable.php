<?php
/**
 * Script: SylvesterCreateTable.php
 * Purpose: Create a table 'baseball_stats' with at least 5 fields and multiple data types.
 * Author: Sylvester
 * Date: April 27, 2026
 * Database: baseball_01, user: student1, password: pass
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
$sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(100) NOT NULL,
    team VARCHAR(60) NOT NULL,
    position VARCHAR(30) NOT NULL,
    home_runs INT(11) NOT NULL,
    batting_avg DECIMAL(4,3) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    $message = "<p style='color:green;'>Table '$tableName' created successfully (or already exists).</p>";
} else {
    $message = "<p style='color:red;'>Error creating table: " . $conn->error . "</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Baseball Stats Table</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Table: baseball_stats</h1>
        <?php echo $message; ?>
        <p><strong>Table Structure:</strong></p>
        <ul>
            <li><code>id</code> INT (Primary Key, Auto Increment)</li>
            <li><code>player_name</code> VARCHAR(100)</li>
            <li><code>team</code> VARCHAR(60)</li>
            <li><code>position</code> VARCHAR(30)</li>
            <li><code>home_runs</code> INT</li>
            <li><code>batting_avg</code> DECIMAL(4,3)</li>
        </ul>
        <p><a href="SylvesterQueryTable.php">View Table</a> | <a href="SylvesterPopulateTable.php">Populate Table</a></p>
    </div>
</body>
</html>