<?php
// Handle logout by deleting the cookie
if (isset($_POST['logout'])) {
    // Delete the cookie by setting it to expire in the past
    setcookie('username', '', time() - 3600, '/');
    // Redirect to inedx.php
    header("Location: inedx.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Home Page</title>
</head>
<body>
    <h1>Home Page</h1>

    <?php
    // Check if the username cookie is set
    if (isset($_COOKIE['username'])) {
        // Display a welcome message with the username from cookie
        echo "<p>Welcome, " . htmlspecialchars($_COOKIE['username']) . "!</p>";
        // Provide a logout form to delete the cookie
        echo "<form action='home.php' method='post'>";
        echo "<input type='submit' name='logout' value='Logout (Delete Cookie)'>";
        echo "</form>";
    } else {
        // If no cookie, show a message
        echo "<p>No cookie set. Please <a href='inedx.php'>set a cookie</a> first.</p>";
    }
    ?>

    <a href="inedx.php">Back to Set Cookie</a>
</body>
</html>