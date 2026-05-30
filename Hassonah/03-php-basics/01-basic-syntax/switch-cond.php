<html><head></head>
<body>
<!-- switch-cond.php COMP334 -->
<?php
// PHP basics example
$x = rand(1, 5); // get a random integer {1, ..., 5}
echo "x = $x <br/><br/>";
// Choose case
switch ($x) {
    // Case option
    case 1:
        echo "Number 1";
        break;
    // Case option
    case 2:
        echo "Number 2";
        break;
    // Case option
    case 3:
        echo "Number 3";
        break;
    // Case option
    default:
        echo "No number between 1 and 3";
}
?>

</body>
</html>
