<?php
// Session/cookie example
// Start session
session_start(); ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Session example 2</title>
</head>

<body>
    <?php
    // Print output
    echo "Welcome to a new page " . $_SESSION["name"] . "!<br/>\n";
    echo "Hope you enjoy your stay!  <br/>";
    ?>
    <p>Back to regular text.
    </p>
</body>

</html>