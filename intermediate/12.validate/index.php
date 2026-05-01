<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!--
    filter_var() - Filters a variable with a specified filter
    filter_input() - Gets a specific external variable by name and optionally filters it
    filter_input_array() - Gets external variables and optionally filters them
    filter_var_array() - Filters multiple variables with the same or different filters
    FILTER_VALIDATE_EMAIL - Validates an email address
    FILTER_VALIDATE_URL - Validates a URL
    FILTER_VALIDATE_IP - Validates an IP address
    FILTER_VALIDATE_INT - Validates an integer
    FILTER_VALIDATE_FLOAT - Validates a float
    FILTER_VALIDATE_BOOLEAN - Validates a boolean value
    FILTER_SANITIZE_STRING - Removes tags and encodes special characters from a string
    FILTER_SANITIZE_EMAIL - Removes all characters except letters, digits, and !#$%&'*+-/=?^_`{|}~@.[] from an email address
    FILTER_SANITIZE_URL - Removes all characters except letters, digits, and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&= from a URL
    FILTER_SANITIZE_NUMBER_INT - Removes all characters except digits, plus and minus sign from
    an integer
    FILTER_SANITIZE_NUMBER_FLOAT - Removes all characters except digits, plus and minus sign, and optionally [.,eE] from a float
-->


    <header>
      <h1>My webSite</h1>

      <form action="index.php" method="post">
        <input type="text" name="username" placeholder="enter your username">
        <input type="password" name="password" placeholder="enter pas">
        <input type="submit" value="Login">
      </form>
        
    </header>




</body>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

        if ($username === "admin" && $password === "password") {
            echo "Login successful!";
        } else {
            echo "Invalid username or password.";
        }
    }
?>
</html>