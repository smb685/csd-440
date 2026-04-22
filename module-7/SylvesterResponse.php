<?php
/**
 * Form Processor for Personal Information
 * 
 * This script validates all fields from the submitted form,
 * checks for empty fields and correct data types,
 * then displays either a formatted success page or error messages.
 * 
 * @author Your Name
 * @version 1.0
 */

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize error array
$errors = array();

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Error: This script only accepts POST requests.");
}

// Helper function to clean input data
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// --- FIELD VALIDATION ---

// 1. Full Name (string, required)
if (empty($_POST["fullname"])) {
    $errors["fullname"] = "Full name is required.";
} else {
    $fullname = clean_input($_POST["fullname"]);
    // Check if name contains only letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
        $errors["fullname"] = "Only letters and spaces allowed in name.";
    }
}

// 2. Email (string with email format, required)
if (empty($_POST["email"])) {
    $errors["email"] = "Email address is required.";
} else {
    $email = clean_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format.";
    }
}

// 3. Age (integer, required)
if (empty($_POST["age"])) {
    $errors["age"] = "Age is required.";
} else {
    $age = clean_input($_POST["age"]);
    if (!filter_var($age, FILTER_VALIDATE_INT)) {
        $errors["age"] = "Age must be a valid integer.";
    } else {
        $age = (int)$age;
        if ($age < 18 || $age > 120) {
            $errors["age"] = "Age must be between 18 and 120.";
        }
    }
}

// 4. Salary (float/decimal, required)
if (empty($_POST["salary"])) {
    $errors["salary"] = "Monthly salary is required.";
} else {
    $salary = clean_input($_POST["salary"]);
    if (!filter_var($salary, FILTER_VALIDATE_FLOAT)) {
        $errors["salary"] = "Salary must be a valid number (e.g., 2500.50).";
    } else {
        $salary = (float)$salary;
        if ($salary < 0) {
            $errors["salary"] = "Salary cannot be negative.";
        }
    }
}

// 5. Birthdate (date, required)
if (empty($_POST["birthdate"])) {
    $errors["birthdate"] = "Birth date is required.";
} else {
    $birthdate = clean_input($_POST["birthdate"]);
    $date_parts = explode("-", $birthdate);
    if (count($date_parts) != 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
        $errors["birthdate"] = "Invalid date format.";
    }
}

// 6. Department (select dropdown, required)
if (empty($_POST["department"])) {
    $errors["department"] = "Please select a department.";
} else {
    $department = clean_input($_POST["department"]);
    $valid_departments = array("Engineering", "Sales", "Marketing", "HR");
    if (!in_array($department, $valid_departments)) {
        $errors["department"] = "Invalid department selection.";
    }
}

// 7. Work Shift (radio buttons, required)
if (empty($_POST["shift"])) {
    $errors["shift"] = "Please select a work shift.";
} else {
    $shift = clean_input($_POST["shift"]);
    $valid_shifts = array("Morning", "Evening", "Night");
    if (!in_array($shift, $valid_shifts)) {
        $errors["shift"] = "Invalid shift selection.";
    }
}

// --- OUTPUT: Either display errors or formatted success page ---

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .result-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .success {
            border-left: 5px solid #4CAF50;
            background-color: #f0f8f0;
            padding: 15px;
            margin-bottom: 20px;
        }
        .error-display {
            border-left: 5px solid #f44336;
            background-color: #ffe6e6;
            padding: 15px;
            margin-bottom: 20px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .data-table th {
            background-color: #4CAF50;
            color: white;
            width: 35%;
        }
        .data-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .error-list {
            color: #d32f2f;
            font-weight: bold;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #008CBA;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-link:hover {
            background-color: #005f73;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <?php if (empty($errors)): ?>
            <!-- SUCCESS PAGE: Display all entered data -->
            <div class="success">
                <h1>✅ Submission Successful!</h1>
                <p>Thank you, <?php echo $fullname; ?>. Your information has been recorded.</p>
            </div>
            
            <h2>Entered Information:</h2>
            <table class="data-table">
                <tr><th>Field</th><th>Value</th></tr>
                <tr><th>Full Name</th><td><?php echo $fullname; ?></td></tr>
                <tr><th>Email Address</th><td><?php echo $email; ?></td></tr>
                <tr><th>Age</th><td><?php echo $age; ?> years</td></tr>
                <tr><th>Monthly Salary</th><td>$<?php echo number_format($salary, 2); ?></td></tr>
                <tr><th>Birth Date</th><td><?php echo date("F j, Y", strtotime($birthdate)); ?></td></tr>
                <tr><th>Department</th><td><?php echo $department; ?></td></tr>
                <tr><th>Work Shift</th><td><?php echo $shift; ?></td></tr>
            </table>
            
        <?php else: ?>
            <!-- ERROR PAGE: Display all problems -->
            <div class="error-display">
                <h1>❌ Submission Failed</h1>
                <p>Please correct the following errors:</p>
                <ul class="error-list">
                    <?php foreach ($errors as $field => $message): ?>
                        <li><strong><?php echo ucfirst($field); ?>:</strong> <?php echo $message; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <a href="SylvesterForm.html" class="back-link">← Back to Form</a>
    </div>
</body>
</html>