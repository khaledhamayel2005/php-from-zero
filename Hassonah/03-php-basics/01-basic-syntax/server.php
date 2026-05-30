<html><head></head>
<!-- server.php -->
<body>

<?php
// PHP basics example
echo "Referer: " . $_SERVER["HTTP_REFERER"] . "<br />";
echo "Browser: " . $_SERVER["HTTP_USER_AGENT"] . "<br />";
echo "User's IP address: " . $_SERVER["REMOTE_ADDR"];
?>


<?php
echo "<br/><br/><br/>";
echo "<h2>All information</h2>";
foreach ($_SERVER as $key => $value) {
    echo $key . " => " . $value . "<br/>";
}
?>

</body>
</html>
