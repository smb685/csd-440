<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sylvester's First PHP Program</title>
</head>
<body>

    <h1>My First PHP Program</h1>
    <p>Welcome to my first PHP page!</p>

    <?php
        // PHP Snippet 1: Display a greeting message with the current date
        $name = "Sylvester";
        $date = date("F j, Y");
        echo "<p>Hello, my name is <strong>$name</strong> and today is <strong>$date</strong>.</p>";
    ?>

    <hr>

    <?php
        // PHP Snippet 2: Simple addition calculation
        $num1 = 15;
        $num2 = 10;
        $sum = $num1 + $num2;
        echo "<p>The sum of $num1 + $num2 = <strong>$sum</strong></p>";
    ?>

    <footer>
        <p><em>CSD440 - Module 1 Assignment</em></p>
    </footer>

</body>
</html>