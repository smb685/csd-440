<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palindrome Checker - Sylvester Palindrome</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .result-card {
            margin: 15px 0;
            padding: 15px;
            border-left: 5px solid;
            border-radius: 5px;
            background-color: #fafafa;
            transition: transform 0.2s;
        }
        .result-card:hover {
            transform: translateX(5px);
        }
        .palindrome {
            border-left-color: #27ae60;
            background-color: #eafaf1;
        }
        .not-palindrome {
            border-left-color: #e74c3c;
            background-color: #fdedec;
        }
        .string-details {
            font-family: 'Courier New', monospace;
            font-size: 1.1em;
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #7f8c8d;
        }
        .status {
            font-weight: bold;
            margin-top: 8px;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 20px;
        }
        .status-true {
            background-color: #27ae60;
            color: white;
        }
        .status-false {
            background-color: #e74c3c;
            color: white;
        }
        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ddd;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85em;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Palindrome Checker</h1>
        <p style="text-align: center; margin-bottom: 25px;">A palindrome reads the same forward and backward (case-insensitive, ignoring spaces and punctuation).</p>
        
        <?php
        /**
         * Function: isPalindrome
         * Description: Checks if a given string is a palindrome.
         *              The function normalizes the string by removing non-alphanumeric
         *              characters, converting to lowercase, and comparing to its reverse.
         * 
         * @param string $string The input string to test
         * @return bool Returns true if the string is a palindrome, false otherwise
         */
        function isPalindrome($string) {
            // Remove all non-alphanumeric characters (spaces, punctuation, etc.)
            // and convert to lowercase for case-insensitive comparison
            $cleaned = preg_replace("/[^A-Za-z0-9]/", '', $string);
            $cleaned = strtolower($cleaned);
            
            // Reverse the cleaned string
            $reversed = strrev($cleaned);
            
            // Compare original cleaned string with reversed version
            return $cleaned === $reversed;
        }
        
        /**
         * Function: displayResult
         * Description: Displays the palindrome test results for a given string,
         *              showing both original and reversed order.
         * 
         * @param string $testString The string to test and display
         * @param int $exampleNumber The example number (1-6)
         * @return void
         */
        function displayResult($testString, $exampleNumber) {
            // Clean the string for proper reversal (for display purposes)
            $cleanedForReverse = preg_replace("/[^A-Za-z0-9]/", '', $testString);
            $cleanedForReverse = strtolower($cleanedForReverse);
            $reversedDisplay = strrev($cleanedForReverse);
            
            // Check if palindrome
            $isPal = isPalindrome($testString);
            
            // Determine CSS class based on result
            $cardClass = $isPal ? "palindrome" : "not-palindrome";
            $statusClass = $isPal ? "status-true" : "status-false";
            $statusText = $isPal ? "✓ PALINDROME" : "✗ NOT A PALINDROME";
            
            echo "<div class='result-card $cardClass'>";
            echo "<strong>Example $exampleNumber:</strong><br>";
            echo "<div class='string-details'>";
            echo "<span class='label'>Original string:</span> \"$testString\"<br>";
            echo "<span class='label'>Reversed (alphanumeric, lowercase):</span> \"$reversedDisplay\"<br>";
            echo "</div>";
            echo "<div class='status $statusClass'>$statusText</div>";
            echo "</div>";
        }
        
        // Define six test strings: three palindromes and three non-palindromes
        $testExamples = [
            "A man, a plan, a canal: Panama",      // Classic palindrome (ignores spaces/punctuation)
            "racecar",                              // Simple palindrome
            "No 'x' in Nixon",                      // Palindrome with apostrophes and spaces
            "Hello World",                          // Not a palindrome
            "Palindrome",                           // Not a palindrome
            "OpenAI ChatGPT"                        // Not a palindrome
        ];
        
        // Process and display each example
        for ($i = 0; $i < count($testExamples); $i++) {
            displayResult($testExamples[$i], $i + 1);
        }
        
        // Additional verification: Show detailed breakdown for clarity
        echo "<hr>";
        echo "<h3>📊 Summary of Results</h3>";
        echo "<table style='width:100%; border-collapse: collapse;'>";
        echo "<tr style='background-color:#ecf0f1;'><th style='padding:8px; text-align:left;'>#</th>";
        echo "<th style='padding:8px; text-align:left;'>String</th><th style='padding:8px; text-align:left;'>Palindrome?</th></tr>";
        
        $palindromeCount = 0;
        for ($i = 0; $i < count($testExamples); $i++) {
            $isPal = isPalindrome($testExamples[$i]);
            if ($isPal) $palindromeCount++;
            $resultText = $isPal ? "✅ Yes" : "❌ No";
            $rowColor = ($i % 2 == 0) ? "#f9f9f9" : "#ffffff";
            echo "<tr style='background-color:$rowColor;'>";
            echo "<td style='padding:8px;'>" . ($i + 1) . "</td>";
            echo "<td style='padding:8px;'>\"" . htmlspecialchars($testExamples[$i]) . "\"</td>";
            echo "<td style='padding:8px;'>$resultText</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p style='margin-top:15px;'><strong>Total palindromes in test set:</strong> $palindromeCount out of " . count($testExamples) . "</p>";
        ?>
        
        <footer>
            <p>📝 Note: Palindrome test is case-insensitive and ignores all non-alphanumeric characters (spaces, punctuation, etc.).</p>
            <p>John Palindrome | PHP Palindrome Checker</p>
        </footer>
    </div>
</body>
</html>