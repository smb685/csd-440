<?php
/**
 * File: SylvesterCustomers.php
 * Purpose: Creates an array of customers and demonstrates array methods
 *          to search and display records based on different fields.
 * Author: Sylvester
 * Date: 2026-04-15
 */

// Associative array of customers (first name, last name, age, phone number)
$customers = [
    ["first_name" => "John", "last_name" => "Smith", "age" => 32, "phone" => "555-1234"],
    ["first_name" => "Emma", "last_name" => "Johnson", "age" => 28, "phone" => "555-5678"],
    ["first_name" => "Michael", "last_name" => "Williams", "age" => 45, "phone" => "555-8765"],
    ["first_name" => "Sophia", "last_name" => "Brown", "age" => 23, "phone" => "555-4321"],
    ["first_name" => "James", "last_name" => "Jones", "age" => 37, "phone" => "555-9876"],
    ["first_name" => "Olivia", "last_name" => "Garcia", "age" => 29, "phone" => "555-2468"],
    ["first_name" => "Benjamin", "last_name" => "Martinez", "age" => 41, "phone" => "555-1357"],
    ["first_name" => "Amelia", "last_name" => "Rodriguez", "age" => 26, "phone" => "555-7531"],
    ["first_name" => "Lucas", "last_name" => "Lee", "age" => 33, "phone" => "555-9512"],
    ["first_name" => "Mia", "last_name" => "Walker", "age" => 30, "phone" => "555-3579"]
];

// Function to display a single customer as an HTML table row
function displayCustomerRow($customer) {
    echo "<tr>
            <td>{$customer['first_name']}</td>
            <td>{$customer['last_name']}</td>
            <td>{$customer['age']}</td>
            <td>{$customer['phone']}</td>
          </tr>\n";
}

// Function to display an array of customers in an HTML table
function displayCustomerTable($customerArray, $title = "Customer Records") {
    echo "<h3>$title</h3>";
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; margin-bottom: 20px;'>
            <tr style='background-color: #f2f2f2;'>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Phone Number</th>
            </tr>";
    foreach ($customerArray as $customer) {
        displayCustomerRow($customer);
    }
    echo "</table>";
}

// -------- ARRAY METHOD DEMONSTRATIONS --------

// 1. Find customers whose age is between 30 and 40 inclusive (using array_filter)
$customersAge30to40 = array_filter($customers, function($customer) {
    return $customer['age'] >= 30 && $customer['age'] <= 40;
});

// 2. Find customers with last name starting with 'J' (using array_filter)
$customersLastNameJ = array_filter($customers, function($customer) {
    return stripos($customer['last_name'], 'J') === 0; // case-insensitive, starts with J
});

// 3. Find a specific customer by phone number (using array_search + array_column)
$searchPhone = "555-9876";
$indexByPhone = array_search($searchPhone, array_column($customers, 'phone'));
$customerByPhone = ($indexByPhone !== false) ? [$customers[$indexByPhone]] : [];

// 4. Find customers by first name (Emma) - using array_filter
$customerEmma = array_filter($customers, function($customer) {
    return $customer['first_name'] === "Emma";
});

// 5. Sort customers by age (ascending) - using usort (modifies original, so we copy first)
$sortedByAge = $customers;
usort($sortedByAge, function($a, $b) {
    return $a['age'] - $b['age'];
});

// 6. Get all last names using array_column
$allLastNames = array_column($customers, 'last_name');

// 7. Find youngest customer using array_reduce
$youngest = array_reduce($customers, function($carry, $item) {
    if ($carry === null || $item['age'] < $carry['age']) {
        return $item;
    }
    return $carry;
});

// 8. Find oldest customer using array_reduce
$oldest = array_reduce($customers, function($carry, $item) {
    if ($carry === null || $item['age'] > $carry['age']) {
        return $item;
    }
    return $carry;
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Victor's Customer Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        h2 {
            color: #555;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        h3 {
            color: #666;
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
        }
        td {
            padding: 8px;
            text-align: left;
        }
        .summary {
            background-color: #e7f3fe;
            border-left: 6px solid #2196F3;
            padding: 10px;
            margin-bottom: 20px;
        }
        .last-names {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📋 Customer Management System</h1>
    <p><strong>File:</strong> Victor Customers.php | <strong>Total Customers:</strong> <?php echo count($customers); ?></p>

    <!-- Display All Customers -->
    <h2>📇 Complete Customer List</h2>
    <?php displayCustomerTable($customers, "All Customers (10 records)"); ?>

    <!-- Array Method Examples Section -->
    <h2>🔍 Array Method Searches & Filters</h2>

    <!-- 1. Age between 30 and 40 -->
    <?php displayCustomerTable($customersAge30to40, "1️⃣ Customers between ages 30 and 40"); ?>

    <!-- 2. Last name starts with 'J' -->
    <?php displayCustomerTable($customersLastNameJ, "2️⃣ Customers with last name starting with 'J'"); ?>

    <!-- 3. Search by phone number -->
    <?php displayCustomerTable($customerByPhone, "3️⃣ Customer with phone number $searchPhone"); ?>

    <!-- 4. Search by first name 'Emma' -->
    <?php displayCustomerTable($customerEmma, "4️⃣ Customer with first name 'Emma'"); ?>

    <!-- 5. Sorted by age (ascending) -->
    <?php displayCustomerTable($sortedByAge, "5️⃣ Customers sorted by age (ascending)"); ?>

    <!-- 6. List of all last names -->
    <h3>6️⃣ All Last Names (using array_column)</h3>
    <div class="last-names">
        <?php echo implode(" • ", $allLastNames); ?>
    </div>

    <!-- 7. Youngest customer -->
    <h3>7️⃣ Youngest Customer (using array_reduce)</h3>
    <div class="summary">
        <strong>Name:</strong> <?php echo $youngest['first_name'] . " " . $youngest['last_name']; ?><br>
        <strong>Age:</strong> <?php echo $youngest['age']; ?><br>
        <strong>Phone:</strong> <?php echo $youngest['phone']; ?>
    </div>

    <!-- 8. Oldest customer -->
    <h3>8️⃣ Oldest Customer (using array_reduce)</h3>
    <div class="summary">
        <strong>Name:</strong> <?php echo $oldest['first_name'] . " " . $oldest['last_name']; ?><br>
        <strong>Age:</strong> <?php echo $oldest['age']; ?><br>
        <strong>Phone:</strong> <?php echo $oldest['phone']; ?>
    </div>

    <hr>
    <footer style="text-align: center; font-size: 0.8em; color: #777;">
        PHP Array Methods Demonstrated: array_filter, array_column, array_search, usort, array_reduce, implode
    </footer>
</div>
</body>
</html>