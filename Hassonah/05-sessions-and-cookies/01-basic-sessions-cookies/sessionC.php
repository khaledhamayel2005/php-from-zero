<?php
// Session/cookie example
// Start session
session_start(); ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Session example 3</title>
</head>

<body>
    <?php
    // Print output
    echo "Deleting all session variables using session_unset(); <br/>\n";
    // Call function
    session_unset();
    // Print output
    echo "Now the session variables are gone.  <br/>\n";
    // Check condition
    if (isset($_SESSION["name"])) {
        // Print output
        echo $_SESSION["name"] . "<br/>\n";
        // Else branch
    } else {
        // Print output
        echo "Session variable is not here.";
    }
    // Set value
    $_SESSION["name"] = "testing";
    ?>

</body>

</html>