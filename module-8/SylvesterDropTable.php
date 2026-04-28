<?php
/**
 * Script: SylvesterDropTable.php
 * Purpose: Drop the 'baseball_stats' table if it exists.
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
$sql = "DROP TABLE IF EXISTS $tableName";

if ($conn->query($sql) === TRUE) {
    $message = "<p style='color:green;'>Table '$tableName' has been dropped successfully.</p>";
} else {
    $message = "<p style='color:red;'>Error dropping table: " . $conn->error . "</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drop Baseball Stats Table</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Drop Table: baseball_stats</h1>
        <?php echo $message; ?>
        <p><a href="SylvesterCreateTable.php">Re-create Table</a> | <a href="SylvesterQueryTable.php">Check Query</a></p>
    </div>
</body>
</html>