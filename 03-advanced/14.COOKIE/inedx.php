<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Login Page</title>
</head>
<body>
    <h1>Cookie Welcome</h1>
    <p>This page allows you to enter a username and store it in a cookie.</p>
    <a href="home.php">Go to Home</a>

    <form action="inedx.php" method="post">
        <label for="username">Enter Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter username" required>
        <input type="submit" value="Submit">
    </form>

    <?php
    // Check if the form has been submitted and username is set
    if (isset($_POST['username'])) {
        // Set a cookie with the username, expires in 1 hour
        setcookie('username', $_POST['username'], time() + 3600, '/');
        // Display a confirmation message
        echo "<p>Cookie set for username: " . htmlspecialchars($_POST['username']) . "</p>";
        echo "<p>Note: Cookies are stored on the client-side and will be available on the next page load.</p>";
    }
    ?>
</body>
</html>