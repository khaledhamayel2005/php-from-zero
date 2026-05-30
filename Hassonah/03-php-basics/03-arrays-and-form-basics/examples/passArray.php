<!DOCTYPE html>


<html>
<head>
  <title>passing array</title>
</head>
<body>
<?php
// Array/form example
if (isset($_POST["part"])) {
    echo "<h3>Last Burger</h3>\n";
    echo "<ul>\n";
    $arr = $_POST["part"];
    foreach ($arr as $choice) {
        echo "<li>$choice</li>\n";
    }

    echo "</ul>\n";
}

$option = ["mustard", "ketchup", "pickles", "onions", "lettuce", "tomato"];
echo "<h3>Create a Burger</h3>\n";
echo "<form action=\"{$_SERVER["PHP_SELF"]}\" method =\"post\">\n";
foreach ($option as $o) {
    echo "<input type=\"checkbox\" name=\"part[]\" value=\"$o\"> $o<br/>\n";
}
?>
<input type="submit">
</form>
</body>
</html>
