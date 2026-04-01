<!DOCTYPE html>
<!--
    File:        SylvesterTable3.php
    Author:      Sylvester
    Date:        March 31, 2026
    Description: Extension of SylvesterSecondTable.php (Module 2). Generates
                 an HTML table using a PHP nested loop structure. Each cell
                 displays the SUM of two PHP-generated random numbers, computed
                 by the external function addRandomNumbers(), which is defined
                 in sylvester_functions.php. HTML table tags are written in
                 plain HTML; PHP tags open and close only around loop logic
                 and dynamic output.

    Depends on:  sylvester_functions.php (must be in the same directory)
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SylvesterTable3 – Sum of Random Numbers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
        }

        p {
            max-width: 680px;
            line-height: 1.6;
        }

        table {
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        caption {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        th {
            background-color: #4a7cbf;
            color: #fff;
            padding: 10px 16px;
            border: 1px solid #3a6aaf;
        }

        td {
            padding: 10px 16px;
            border: 1px solid #ccc;
            text-align: center;
            min-width: 60px;
        }

        /* Alternate row shading for readability */
        tr:nth-child(even) td {
            background-color: #e8f0fb;
        }

        tr:nth-child(odd) td {
            background-color: #f9f9f9;
        }

        td:hover {
            background-color: #d0e4ff;
            cursor: default;
        }
    </style>
</head>
<body>

    <h1>PHP Random Number Table</h1>
    <p>
        Each cell below contains the <strong>sum of two random integers</strong>
        (each between <strong>1</strong> and <strong>100</strong>), returned by
        <code>addRandomNumbers()</code> — an external PHP function defined in
        <code>sylvester_functions.php</code>. The table is built with a nested
        PHP loop: the outer loop controls rows and the inner loop controls columns.
    </p>

    <?php
        /* -------------------------------------------------------
         * Step 1 – Load the external functions file.
         * require_once halts execution if the file is missing,
         * preventing silent failures.
         * ------------------------------------------------------- */
        require_once 'sylvester_functions.php';

        /* -------------------------------------------------------
         * Step 2 – Configuration
         * Set the number of rows and columns for the table here.
         * ------------------------------------------------------- */
        $numRows = 6;   // Total rows in the data table
        $numCols = 8;   // Total columns in the data table
        $minVal  = 1;   // Minimum random number (inclusive)
        $maxVal  = 100; // Maximum random number (inclusive)
    ?>

    <table>
        <caption>
            <?php echo $numRows; ?> &times; <?php echo $numCols; ?>
            Table of Random Integer Sums (each addend <?php echo $minVal; ?>–<?php echo $maxVal; ?>)
        </caption>

        <!-- ── Header row: Column labels ── -->
        <thead>
            <tr>
                <th>Row \ Col</th>
                <?php
                    /* Print one header cell per column */
                    for ($col = 1; $col <= $numCols; $col++) {
                        echo "<th>Col $col</th>";
                    }
                ?>
            </tr>
        </thead>

        <!-- ── Body: nested loop fills each cell with the sum of two random numbers ── -->
        <tbody>
            <?php
                /*
                 * Outer loop – iterates over each row.
                 * HTML <tr> tags are written in plain HTML; PHP opens and
                 * closes only around the loop logic, per assignment requirements.
                 */
                for ($row = 1; $row <= $numRows; $row++):
            ?>
            <tr>
                <!-- Row label -->
                <th>Row <?php echo $row; ?></th>

                <?php
                    /*
                     * Inner loop – iterates over each column within the
                     * current row and writes one <td> per column.
                     * Two random numbers are generated and passed to the
                     * external function addRandomNumbers(), which returns
                     * their sum for display in the cell.
                     */
                    for ($col = 1; $col <= $numCols; $col++) {
                        $num1      = rand($minVal, $maxVal); // First random number
                        $num2      = rand($minVal, $maxVal); // Second random number
                        $cellValue = addRandomNumbers($num1, $num2); // External function call
                        echo "<td>$cellValue</td>\n";
                    }
                ?>
            </tr>
            <?php
                endfor; // End of outer (row) loop
            ?>
        </tbody>
    </table>

    <p><em>Reload the page to generate a new set of random sums.</em></p>

</body>
</html>
