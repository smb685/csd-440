<?php
/**
 * Sylvester_JSON.php
 * 
 * A form program that collects at least 8 different fields of user data,
 * encodes the submitted data into JSON format using json_encode(),
 * and displays the JSON in a well-formatted output.
 * 
 * If validation fails, an error display is shown instead.
 * 
 * @author Sylvester
 * @version 1.0
 * @date 2026-05-13
 */

// Initialize variables
$errors = [];
$submittedData = [];
$jsonOutput = null;
$showJson = false;

// List of required fields (minimum 8 fields – we use 9)
$requiredFields = [
    'full_name' => 'Full Name',
    'email'     => 'Email Address',
    'phone'     => 'Phone Number',
    'dob'       => 'Date of Birth',
    'address'   => 'Street Address',
    'city'      => 'City',
    'state'     => 'State / Province',
    'zip'       => 'ZIP / Postal Code',
    'country'   => 'Country'
];

// Process form submission (POST method)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve and trim each field
    foreach ($requiredFields as $field => $label) {
        $submittedData[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : '';
        if (empty($submittedData[$field])) {
            $errors[$field] = "The field '$label' is required.";
        }
    }
    
    // Optional: basic email format validation
    if (empty($errors['email']) && !filter_var($submittedData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }
    
    // If no errors, encode data to JSON
    if (empty($errors)) {
        // Prepare associative array with all field data
        $dataToEncode = [];
        foreach ($requiredFields as $field => $label) {
            $dataToEncode[$field] = $submittedData[$field];
        }
        
        // Encode to JSON with pretty print for readability
        $jsonOutput = json_encode($dataToEncode, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        
        // Check if encoding was successful
        if ($jsonOutput === false) {
            $errors['encoding'] = "Failed to encode data to JSON. Please try again.";
        } else {
            $showJson = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>User Data Form | JSON Encoder</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        body {
            background: linear-gradient(145deg, #f4f7fc 0%, #e9eef4 100%);
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1.5rem;
        }
        .main-container {
            max-width: 1100px;
            width: 100%;
            background: white;
            border-radius: 2rem;
            box-shadow: 0 25px 45px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .form-header {
            background: #1f3a5f;
            color: white;
            padding: 1.5rem 2rem;
        }
        .form-header h1 {
            margin: 0;
            font-weight: 600;
            font-size: 1.8rem;
            letter-spacing: -0.3px;
        }
        .form-header p {
            margin: 0.5rem 0 0;
            opacity: 0.85;
        }
        .content-panel {
            padding: 2rem 2rem 2rem 2rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }
        .input-group label {
            font-weight: 600;
            color: #1e2f41;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }
        .input-group label::after {
            content: " *";
            color: #c44536;
            font-weight: bold;
        }
        .input-group input, 
        .input-group select {
            padding: 0.8rem 1rem;
            border: 1.5px solid #cfdfed;
            border-radius: 1rem;
            font-size: 0.95rem;
            transition: 0.2s;
            background: #fefefe;
        }
        .input-group input:focus, 
        .input-group select:focus {
            outline: none;
            border-color: #2c6e9e;
            box-shadow: 0 0 0 3px rgba(44,110,158,0.2);
        }
        button {
            background: #1f3a5f;
            color: white;
            border: none;
            padding: 0.9rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 3rem;
            cursor: pointer;
            width: 100%;
            transition: 0.2s;
            margin-top: 0.5rem;
            letter-spacing: 0.5px;
        }
        button:hover {
            background: #0f2a48;
            transform: scale(0.98);
            box-shadow: 0 8px 18px rgba(0,0,0,0.1);
        }
        .error-display {
            background: #ffe9e6;
            border-left: 6px solid #d9534f;
            border-radius: 1.2rem;
            padding: 1.2rem 1.8rem;
            margin-bottom: 2rem;
            color: #a1241f;
        }
        .error-display h3 {
            margin: 0 0 0.5rem 0;
            font-weight: 700;
        }
        .error-list {
            margin: 0;
            padding-left: 1.2rem;
        }
        .error-list li {
            margin: 0.3rem 0;
        }
        .json-output {
            background: #1e2f3a;
            border-radius: 1.2rem;
            padding: 1.2rem;
            margin-top: 1.2rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border: 1px solid #2e4a62;
        }
        .json-output h3 {
            color: #cbe4fe;
            margin: 0 0 0.8rem 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .json-output pre {
            background: #0f1a22;
            color: #e6f7ff;
            padding: 1.2rem;
            border-radius: 1rem;
            overflow-x: auto;
            font-family: 'Fira Code', 'Cascadia Code', monospace;
            font-size: 0.85rem;
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .success-badge {
            background: #2c6e9e20;
            padding: 0.3rem 0.8rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: normal;
        }
        hr {
            margin: 1.5rem 0 0.5rem;
            border: none;
            height: 2px;
            background: #e2e8f0;
        }
        .field-note {
            font-size: 0.7rem;
            color: #5e6f8d;
            margin-top: 0.2rem;
        }
        @media (max-width: 680px) {
            .content-panel {
                padding: 1.5rem;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="form-header">
        <h1>📋 Multi‑Field Data Form</h1>
        <p>Enter all required fields (minimum 8) → JSON output on successful submission</p>
    </div>
    <div class="content-panel">
        <!-- Display error messages if any (and JSON not shown) -->
        <?php if (!empty($errors) && !$showJson): ?>
            <div class="error-display">
                <h3>⚠️ Submission Error</h3>
                <ul class="error-list">
                    <?php foreach ($errors as $errorMsg): ?>
                        <li><?php echo htmlspecialchars($errorMsg); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p style="margin-top: 0.8rem; font-size: 0.9rem;">Please correct the fields above and resubmit.</p>
            </div>
        <?php endif; ?>

        <!-- Display JSON output in a well‑formatted container when successful -->
        <?php if ($showJson && $jsonOutput !== null): ?>
            <div class="json-output">
                <h3>✨ JSON Output <span class="success-badge">encoded with json_encode()</span></h3>
                <pre><?php echo htmlspecialchars($jsonOutput); ?></pre>
                <p style="color:#bbd4f0; font-size:0.8rem; margin-top: 0.8rem;">✔ Data successfully encoded to JSON.</p>
            </div>
            <hr />
        <?php endif; ?>

        <!-- Data Entry Form (always visible, sticky values for better UX) -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
            <div class="form-grid">
                <?php foreach ($requiredFields as $field => $label): 
                    $fieldValue = isset($submittedData[$field]) ? $submittedData[$field] : '';
                    $inputType = 'text';
                    if ($field === 'email') $inputType = 'email';
                    if ($field === 'phone') $inputType = 'tel';
                    if ($field === 'dob') $inputType = 'date';
                    if ($field === 'zip') $inputType = 'text';
                ?>
                <div class="input-group">
                    <label for="<?php echo $field; ?>"><?php echo htmlspecialchars($label); ?></label>
                    <input type="<?php echo $inputType; ?>" 
                           id="<?php echo $field; ?>" 
                           name="<?php echo $field; ?>"
                           value="<?php echo htmlspecialchars($fieldValue); ?>"
                           placeholder="Enter <?php echo htmlspecialchars($label); ?>"
                           <?php echo ($field === 'dob' ? 'max="'.date('Y-m-d').'"' : ''); ?>
                           required>
                    <?php if ($field === 'phone'): ?>
                        <div class="field-note">Format: numeric, with or without dashes</div>
                    <?php elseif ($field === 'dob'): ?>
                        <div class="field-note">YYYY-MM-DD format</div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="submit">🚀 Submit & Generate JSON</button>
            <p style="font-size: 0.75rem; text-align: center; margin-top: 1rem; color: #5a6e8a;">
                * All <?php echo count($requiredFields); ?> fields are mandatory.<br>
                Upon success, your data will be displayed as structured JSON.
            </p>
        </form>
    </div>
</div>
</body>
</html>