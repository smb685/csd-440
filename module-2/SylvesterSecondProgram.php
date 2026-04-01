<!DOCTYPE html>
<!--
    File:        SylvesterSecondTable.php
    Author:      Sylvester
    Date:        March 31, 2026
    Description: Generates an HTML table of random numbers using PHP nested
                 loop structures. The outer loop creates rows and the inner
                 loop creates columns. Random integers are displayed in each
                 cell. HTML table tags are written in plain HTML; only the
                 loop logic and random number generation use PHP.
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SylvesterTable2 – Random Number Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
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

        caption {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }
    </style>
</head>
<body>

    <h1>PHP Random Number Table</h1>
    <p>
        Each cell below contains a PHP-generated random integer between
        <strong>1</strong> and <strong>100</strong>.
        The table is built with a nested PHP loop: the outer loop controls
        rows and the inner loop controls columns.
    </p>

    <?php
        /* -------------------------------------------------------
         * Configuration
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
            Table of Random Integers (<?php echo $minVal; ?>–<?php echo $maxVal; ?>)
        </caption>

        <!-- ── Header row: Column labels ── -->
        <thead>
            <tr>
                <th>Row \ Col</th>
                <?php
                    /* Inner loop: print a header cell for each column */
                    for ($col = 1; $col <= $numCols; $col++) {
                        echo "<th>Col $col</th>";
                    }
                ?>
            </tr>
        </thead>

        <!-- ── Body: nested loop fills each cell with a random number ── -->
        <tbody>
            <?php
                /*
                 * Outer loop – iterates over each row.
                 * For every row, HTML <tr> tags are written in plain HTML
                 * (PHP tags open/close around the loop logic only).
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
                     * rand() generates a new random integer for every cell.
                     */
                    for ($col = 1; $col <= $numCols; $col++) {
                        $randomNumber = rand($minVal, $maxVal);
                        echo "<td>$randomNumber</td>\n";
                    }
                ?>
            </tr>
            <?php
                endfor; // End of outer (row) loop
            ?>
        </tbody>
    </table>

    <p><em>Reload the page to generate a new set of random numbers.</em></p>

</body>
</html>