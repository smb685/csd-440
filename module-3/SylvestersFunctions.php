<?php
/*
 * File:        sylvester_functions.php
 * Author:      Sylvester
 * Date:        March 31, 2026
 * Description: External library of reusable PHP functions for the Table
 *              assignment series. Contains addRandomNumbers(), which accepts
 *              two integers and returns their sum. This file is included
 *              by SylvesterTable3.php via require_once.
 *
 * Usage:       require_once 'sylvester_functions.php';
 *              $result = addRandomNumbers($a, $b);
 */

/* ---------------------------------------------------------------
 * Function:    addRandomNumbers
 * Parameters:  $num1 (int) – first  randomly generated number
 *              $num2 (int) – second randomly generated number
 * Returns:     int  – the arithmetic sum of $num1 and $num2
 * Description: Takes two random integers as arguments and returns
 *              their sum. Called once per table cell in Table3.
 * --------------------------------------------------------------- */
function addRandomNumbers(int $num1, int $num2): int
{
    return $num1 + $num2;
}
?>
