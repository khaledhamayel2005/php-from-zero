<html><head></head>
<!-- for.php -->
<body>

<?php
// PHP basics example
for ($i = 1; $i <= 5; $i++) {
    echo "Hello World!<br /> \n";
} ?>

<br />

<?php
$a_array = [1, 2, 3, 4];
foreach ($a_array as $value) {
    $value = $value * 2;
    echo "$value <br/> \n";
}
?>
</br>
<?php
for ($i = 1; $i <= sizeof($a_array); $i++) {
    echo "$a_array[$i]<br /> \n";
} ?>
</br>

<?php
$a_array = ["a", "b", "c"];
foreach ($a_array as $key => $value) {
    echo $key . " = " . $value . "</br>";
}
?>

</body>
</html>
