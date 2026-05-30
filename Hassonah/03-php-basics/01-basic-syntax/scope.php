<html><head></head>
<!-- var.php -->
<body>

<?php
// PHP basics example
$a = 1; /* global scope */
function Test()
{
    echo "$a \n";
    /* reference to local scope variable */
}
Test();
?>

</br>

<?php
$a = 1;
$b = 2;
function Sum()
{
    global $a, $b;
    $b = $a + $b;
}
Sum();
echo "$b \n";
?>

</br>

<?php
function Test1()
{
    static $a = 0;
    echo "$a \n";
    $a++;
}
Test1();
Test1();
Test1();
?>


</body>
</html>
