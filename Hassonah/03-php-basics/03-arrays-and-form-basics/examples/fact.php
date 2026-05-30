<!DOCTYPE html>


<html>
<head>
  <title> Factorial Example</title>
</head>
<body>
<?php
// Array/form example
if (isset($_GET["num"])) {
    $num = $_GET["num"];
    $fact = 1;
    for ($i = 1; $i <= $num; $i++) {
        $fact *= $i;
    }
    echo "<h2> {$_GET["num"]} ! is $fact </h2>";
} else {
    echo "wrong input";
} ?>
</body>
</html>
