<?php
/**
 * Script: SylvesterSearch.php
 * Purpose: Search the baseball_stats table based on user input (player name, team, HR range, batting avg).
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
$results = "";
$searchPerformed = false;
$rowCount = 0;

// Check if table exists
$tableCheck = $conn->query("SHOW TABLES LIKE '$tableName'");
if ($tableCheck->num_rows == 0) {
    $tableError = "<p style='color:red;'>Table '$tableName' does not exist. Please run <strong>SylvesterCreateTable.php</strong> first.</p>";
} else {
    $tableError = "";
    
    // Get search parameters
    $player_name = isset($_GET['player_name']) ? trim($_GET['player_name']) : '';
    $team = isset($_GET['team']) ? trim($_GET['team']) : '';
    $position = isset($_GET['position']) ? trim($_GET['position']) : '';
    $min_hr = isset($_GET['min_hr']) && $_GET['min_hr'] !== '' ? (int)$_GET['min_hr'] : null;
    $max_hr = isset($_GET['max_hr']) && $_GET['max_hr'] !== '' ? (int)$_GET['max_hr'] : null;
    $min_avg = isset($_GET['min_avg']) && $_GET['min_avg'] !== '' ? (float)$_GET['min_avg'] : null;
    
    // Only search if at least one filter is provided
    if ($player_name !== '' || $team !== '' || $position !== '' || $min_hr !== null || $max_hr !== null || $min_avg !== null) {
        $searchPerformed = true;
        
        // Build dynamic WHERE clause
        $whereClauses = [];
        $paramTypes = '';
        $paramValues = [];
        
        if ($player_name !== '') {
            $whereClauses[] = "player_name LIKE ?";
            $paramTypes .= 's';
            $paramValues[] = "%$player_name%";
        }
        if ($team !== '') {
            $whereClauses[] = "team LIKE ?";
            $paramTypes .= 's';
            $paramValues[] = "%$team%";
        }
        if ($position !== '') {
            $whereClauses[] = "position LIKE ?";
            $paramTypes .= 's';
            $paramValues[] = "%$position%";
        }
        if ($min_hr !== null) {
            $whereClauses[] = "home_runs >= ?";
            $paramTypes .= 'i';
            $paramValues[] = $min_hr;
        }
        if ($max_hr !== null) {
            $whereClauses[] = "home_runs <= ?";
            $paramTypes .= 'i';
            $paramValues[] = $max_hr;
        }
        if ($min_avg !== null) {
            $whereClauses[] = "batting_avg >= ?";
            $paramTypes .= 'd';
            $paramValues[] = $min_avg;
        }
        
        $sql = "SELECT id, player_name, team, position, home_runs, batting_avg FROM $tableName";
        if (count($whereClauses) > 0) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }
        $sql .= " ORDER BY home_runs DESC, batting_avg DESC";
        
        $stmt = $conn->prepare($sql);
        if (count($paramValues) > 0) {
            $stmt->bind_param($paramTypes, ...$paramValues);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $rowCount = $result->num_rows;
        
        if ($rowCount > 0) {
            $results = "<table class='results-table'>
                            <thead>
                                <tr>
                                    <th>ID</th><th>Player Name</th><th>Team</th><th>Position</th><th>HR</th><th>Batting Avg</th>
                                </tr>
                            </thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                $results .= "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['player_name']) . "</td>
                                <td>" . htmlspecialchars($row['team']) . "</td>
                                <td>" . htmlspecialchars($row['position']) . "</td>
                                <td>" . htmlspecialchars($row['home_runs']) . "</td>
                                <td>" . number_format($row['batting_avg'], 3) . "</td>
                             </tr>";
            }
            $results .= "</tbody></table>";
        } else {
            $results = "<p class='no-results'>😞 No players match your search criteria.</p>";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sylvester - Search Baseball Players</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        .search-form { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #ddd; }
        .form-group { display: inline-block; margin-right: 15px; margin-bottom: 10px; }
        .form-group label { display: block; font-size: 0.8em; font-weight: bold; }
        .form-group input { padding: 6px; width: 140px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #4CAF50; color: white; border: none; padding: 8px 18px; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        button:hover { background: #45a049; }
        .results-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .results-table th, .results-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .results-table th { background-color: #4CAF50; color: white; }
        .results-table tr:nth-child(even) { background-color: #f9f9f9; }
        .no-results { color: #d9534f; font-weight: bold; margin-top: 20px; }
        .count { font-weight: bold; margin-top: 15px; }
        .nav-links { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 15px; }
        .nav-links a { margin-right: 15px; text-decoration: none; background: #007BFF; color: white; padding: 5px 10px; border-radius: 4px; }
        .nav-links a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔎 Search Baseball Players</h1>
        
        <div class="search-form">
            <form method="GET" action="">
                <div class="form-group">
                    <label>Player Name</label>
                    <input type="text" name="player_name" value="<?php echo isset($_GET['player_name']) ? htmlspecialchars($_GET['player_name']) : ''; ?>" placeholder="e.g., Babe">
                </div>
                <div class="form-group">
                    <label>Team</label>
                    <input type="text" name="team" value="<?php echo isset($_GET['team']) ? htmlspecialchars($_GET['team']) : ''; ?>" placeholder="Yankees">
                </div>
                <div class="form-group">
                    <label>Position</label>
                    <input type="text" name="position" value="<?php echo isset($_GET['position']) ? htmlspecialchars($_GET['position']) : ''; ?>" placeholder="OF, SS, etc.">
                </div>
                <div class="form-group">
                    <label>Min Home Runs</label>
                    <input type="number" name="min_hr" value="<?php echo isset($_GET['min_hr']) ? htmlspecialchars($_GET['min_hr']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Max Home Runs</label>
                    <input type="number" name="max_hr" value="<?php echo isset($_GET['max_hr']) ? htmlspecialchars($_GET['max_hr']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Min Batting Avg (≥)</label>
                    <input type="number" step="0.001" name="min_avg" value="<?php echo isset($_GET['min_avg']) ? htmlspecialchars($_GET['min_avg']) : ''; ?>" placeholder="0.300">
                </div>
                <div><button type="submit">🔍 Search</button></div>
            </form>
        </div>

        <?php if (!empty($tableError)): ?>
            <?php echo $tableError; ?>
        <?php elseif ($searchPerformed): ?>
            <h2>Search Results</h2>
            <?php echo $results; ?>
            <?php if ($rowCount > 0): ?>
                <div class="count">📊 Total players found: <?php echo $rowCount; ?></div>
            <?php endif; ?>
        <?php elseif (isset($_GET['player_name']) || isset($_GET['team']) || isset($_GET['position']) || isset($_GET['min_hr']) || isset($_GET['max_hr']) || isset($_GET['min_avg'])): ?>
            <p>⚠️ Please enter at least one search filter above and click Search.</p>
        <?php else: ?>
            <p>✨ Enter search criteria above (e.g., player name, team, HR range) to find players.</p>
        <?php endif; ?>

        <div class="nav-links">
            <a href="SylvesterIndex.php">🏠 Home</a>
            <a href="SylvesterCreateTable.php">Create Table</a>
            <a href="SylvesterPopulateTable.php">Populate Table</a>
            <a href="SylvesterQueryTable.php">View All</a>
            <a href="SylvesterAddForm.php">Add Record</a>
        </div>
    </div>
</body>
</html>