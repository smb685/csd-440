<?php
/**
 * Script: SylvesterAddForm.php
 * Purpose: Display a form to add a new baseball player record and process insertion.
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
$message = "";
$messageClass = "";
$formData = ['player_name' => '', 'team' => '', 'position' => '', 'home_runs' => '', 'batting_avg' => ''];

// Check if table exists
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName'")->num_rows > 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (!$tableExists) {
        $message = "Table '$tableName' does not exist. Please create it first using <strong>SylvesterCreateTable.php</strong>.";
        $messageClass = "error";
    } else {
        // Sanitize and validate inputs
        $player_name = trim($_POST['player_name'] ?? '');
        $team = trim($_POST['team'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $home_runs = isset($_POST['home_runs']) ? (int)$_POST['home_runs'] : -1;
        $batting_avg = isset($_POST['batting_avg']) ? (float)$_POST['batting_avg'] : -1;
        
        $errors = [];
        if (empty($player_name)) $errors[] = "Player name is required.";
        if (empty($team)) $errors[] = "Team is required.";
        if (empty($position)) $errors[] = "Position is required.";
        if ($home_runs < 0) $errors[] = "Home runs must be a non-negative integer.";
        if ($batting_avg < 0 || $batting_avg > 1) $errors[] = "Batting average must be between 0.000 and 1.000.";
        
        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (player_name, team, position, home_runs, batting_avg) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssid", $player_name, $team, $position, $home_runs, $batting_avg);
            if ($stmt->execute()) {
                $message = "✅ Record for <strong>" . htmlspecialchars($player_name) . "</strong> added successfully! (ID: " . $stmt->insert_id . ")";
                $messageClass = "success";
                // Reset form fields after success
                $formData = ['player_name' => '', 'team' => '', 'position' => '', 'home_runs' => '', 'batting_avg' => ''];
            } else {
                $message = "❌ Database error: " . $stmt->error;
                $messageClass = "error";
            }
            $stmt->close();
        } else {
            $message = "❌ Validation errors:<br><ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
            $messageClass = "error";
            $formData = ['player_name' => htmlspecialchars($player_name), 'team' => htmlspecialchars($team), 'position' => htmlspecialchars($position), 'home_runs' => $home_runs, 'batting_avg' => $batting_avg];
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sylvester - Add Baseball Record</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 650px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 130px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 250px; padding: 6px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #4CAF50; color: white; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em; margin-top: 10px; }
        button:hover { background: #45a049; }
        .message { margin: 15px 0; padding: 12px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .nav-links { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 15px; }
        .nav-links a { margin-right: 15px; text-decoration: none; background: #007BFF; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.9em; }
        .nav-links a:hover { background: #0056b3; }
        .example { font-size: 0.8em; color: #666; margin-top: 5px; margin-left: 135px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Add New Baseball Player</h1>
        
        <?php if (!$tableExists && empty($message)): ?>
            <div class="message warning">⚠️ Table '<strong>baseball_stats</strong>' does not exist. Please <a href="SylvesterCreateTable.php">create it</a> first.</div>
        <?php endif; ?>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Player Name *:</label>
                <input type="text" name="player_name" value="<?php echo $formData['player_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Team *:</label>
                <input type="text" name="team" value="<?php echo $formData['team']; ?>" required>
            </div>
            <div class="form-group">
                <label>Position *:</label>
                <input type="text" name="position" value="<?php echo $formData['position']; ?>" placeholder="e.g., SS, OF, 1B" required>
            </div>
            <div class="form-group">
                <label>Home Runs *:</label>
                <input type="number" name="home_runs" value="<?php echo $formData['home_runs']; ?>" min="0" required>
            </div>
            <div class="form-group">
                <label>Batting Avg *:</label>
                <input type="number" step="0.001" name="batting_avg" value="<?php echo $formData['batting_avg']; ?>" min="0" max="1" placeholder="0.000 to 1.000" required>
                <div class="example">e.g., 0.312</div>
            </div>
            <button type="submit" name="submit">💾 Save Player Record</button>
        </form>
        
        <div class="nav-links">
            <a href="SylvesterIndex.php">🏠 Home</a>
            <a href="SylvesterQueryTable.php">View All Stats</a>
            <a href="SylvesterSearch.php">Search Players</a>
            <a href="SylvesterPopulateTable.php">Insert Samples</a>
        </div>
    </div>
</body>
</html>