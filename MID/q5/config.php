<?php
session_start();

/*
    If the user submits the form,
    save the client name in a cookie for 24 hours,
    and reset the access counter.
*/
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["clientName"])) {

    $name = $_POST["clientName"];

    // Cookie valid for 24 hours
    setcookie("clientName", $name, time() + 24 * 60 * 60);

    // Reset visit counter
    $_SESSION["accessCount"] = 1;

    // Make the name available immediately in this request
    $_COOKIE["clientName"] = $name;
}


// If the cookie exists
if (isset($_COOKIE["clientName"]) && !empty($_COOKIE["clientName"])) {

    // If counter does not exist, initialize it
    if (!isset($_SESSION["accessCount"])) {
        $_SESSION["accessCount"] = 1;
    } else {
        $_SESSION["accessCount"]++;
    }

    $name = $_COOKIE["clientName"];
    $count = $_SESSION["accessCount"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Access Counter</title>
</head>
<body>

<?php if (!isset($_COOKIE["clientName"]) || empty($_COOKIE["clientName"])): ?>

    <form method="post">
        <label>Enter your name:</label>
        <input type="text" name="clientName">

        <br><br>

        <input type="submit" value="Submit">
    </form>

<?php else:11 ?>

    <p>
        Dear <?php echo htmlspecialchars($name); ?>,
        during the last 24 hours this is your
        <?php echo htmlspecialchars($count); ?> th visit.
    </p>

<?php endif; ?>

</body>
</html>