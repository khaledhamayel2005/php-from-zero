<!DOCTYPE html>


<html>
<head>
  <title> Factorial Example</title>
</head>
<body>
<?php
// Array/form example
function printForm()
{
    ?>

    
<form method="get" action="factExV2.php" >
  <label for="num">Enter An Integer number to find its Factorial: </label>
  <input type="text" name="num" id="num" required/><br/>
  <input type="submit" value ="Calculate"/>
</form>

<?php

}

if (isset($_GET["num"])) {
    $num = $_GET["num"];
    $fact = 1;
    for ($i = 1; $i <= $num; $i++) {
        $fact *= $i;
    }
    echo "<h2> {$_GET["num"]} ! is $fact </h2>";
}
printForm();
?>
</body>
</html>