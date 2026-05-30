<html><head></head>
<!-- fun.php -->
<body>

<?php
// PHP basics example
function square($num)
{
    return $num * $num;
}
echo "<h2>", square(4), "</h3>";

// outputs '16'.
?>

<?php
function small_numbers()
{
    return [0, 1, 2];
}
[$zero, $one, $two] = small_numbers();
echo "<h3> $zero $one $two <h2>";
?>

<?php
function takes_array($input)
{
    echo "<h3> $input[0] + $input[1] = ", $input[0] + $input[1], "</h3>";
}
takes_array([1, 2]);
?>

</body>
</html>
