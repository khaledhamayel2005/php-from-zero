<html>
<head><title></title></head>
<body>
<?php
// Form example
$price = isset($_POST["Price"]) ? $_POST["Price"] : 0;
echo "Price Range: $price";
echo "<br>Engine Size(s):\n <ul>";

foreach ($_POST["EngineSize"] as $choice) {
    echo "<li>$choice</li>";
}
echo "</ul>";
?>
</body>
</html>

