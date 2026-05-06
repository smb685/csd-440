<?php
/**
 * Script: SylvesterIndex.php
 * Purpose: Index page with navigation links to all baseball stats management pages.
 * Author: Sylvester
 * Date: April 27, 2026
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sylvester - Baseball Stats Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        .nav-links { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; }
        .nav-card { background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; padding: 15px 20px; flex: 1 1 200px; text-align: center; transition: 0.2s; }
        .nav-card:hover { background: #e9e9e9; transform: translateY(-2px); }
        .nav-card a { text-decoration: none; font-weight: bold; color: #4CAF50; font-size: 1.1em; }
        .nav-card p { margin: 10px 0 0; color: #666; font-size: 0.85em; }
        .footer { margin-top: 30px; text-align: center; font-size: 0.8em; color: #888; border-top: 1px solid #ddd; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚾ Baseball Stats Management</h1>
        <p>Welcome, Sylvester. Use the links below to manage the <strong>baseball_stats</strong> table.</p>
        
        <div class="nav-links">
            <div class="nav-card">
                <a href="SylvesterCreateTable.php">📋 Create Table</a>
                <p>Create the baseball_stats table</p>
            </div>
            <div class="nav-card">
                <a href="SylvesterDropTable.php">🗑️ Drop Table</a>
                <p>Delete the table</p>
            </div>
            <div class="nav-card">
                <a href="SylvesterPopulateTable.php">📥 Populate Table</a>
                <p>Insert sample player data</p>
            </div>
            <div class="nav-card">
                <a href="SylvesterQueryTable.php">👁️ View All Stats</a>
                <p>Display all records</p>
            </div>
            <div class="nav-card">
                <a href="SylvesterSearch.php">🔍 Search Players</a>
                <p>Find players by criteria</p>
            </div>
            <div class="nav-card">
                <a href="SylvesterAddForm.php">➕ Add New Record</a>
                <p>Insert a new baseball player</p>
            </div>
        </div>
        <div class="footer">
            Database: baseball_01 | Table: baseball_stats | MySQLi
        </div>
    </div>
</body>
</html>