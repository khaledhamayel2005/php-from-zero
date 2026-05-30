<?php
// Session/cookie example
// Set cookie expiration to 24 hours
$cookie_expiration = time() + 24 * 60 * 60;

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"])) {
    $username = htmlspecialchars(trim($_POST["username"]));

    // Create cookie data as JSON
    $data = [
        "name" => $username,
        "visits" => 1,
        "first_visit" => date("Y-m-d H:i:s"),
    ];
    $cookie_data = json_encode($data);

    // Set the cookie
    // Set cookie
    setcookie("user_data", $cookie_data, $cookie_expiration, "/");

    // Redirect to avoid form resubmission
    // Send header
    header("Location: " . $_SERVER["PHP_SELF"]);
    // Stop script
    exit();
}

// Check if cookie exists
$user_data = null;
if (isset($_COOKIE["user_data"])) {
    $user_data = json_decode($_COOKIE["user_data"], true);

    // Increment visit counter
    $user_data["visits"]++;

    // Update cookie with new visit count
    $updated_cookie = json_encode($user_data);
    // Set cookie
    setcookie("user_data", $updated_cookie, $cookie_expiration, "/");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Example - User Visits</title>
</head>
<body>
    <?php
    if ($user_data): ?>
        <!-- Returning visitor -->
                                <h1>Welcome back, <?php echo htmlspecialchars(
            $user_data["name"],
        ); ?>!</h1>
                                <p><strong>Number of visits in the last 24 hours:</strong> <?php echo $user_data[
            "visits"
        ]; ?></p>
                                <p><strong>First visit:</strong> <?php echo $user_data[
            "first_visit"
        ]; ?></p>
        <p>This cookie will expire in 24 hours from your first visit.</p>
        <hr/>
        <pre>
          <p>This output shows the JSON object in a readable format.</p>
          <?php
          echo json_encode($user_data, JSON_PRETTY_PRINT); ?>
        </pre>
        <hr/>
        <a href="reset.php">Reset Cookie</a>
    <?php

        else: ?>
        <!-- First-time visitor -->
        <h1>Welcome!</h1>
        <p>It looks like this is your first visit. Please enter your name to get started:</p>

        <form method="POST" action="">
            <label for="username">Your Name:</label><br>
            <input type="text" id="username" name="username" required placeholder="Enter your name"><br><br>
            <button type="submit">Submit</button>
        </form>

        <p>We'll remember you for the next 24 hours using cookies!</p>
    <?php
    endif; ?>
</body>
</html>
