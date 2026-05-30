<?php
// Session/cookie example
// Start session
session_start(); ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Session example</title>
</head>

<body>
    <?php
    // Load file
    include_once "object.php";
    // Set value
    $_SESSION["hello"] = "Hello world";
    // Print output
    echo $_SESSION["hello"] . "<br/><br/>\n";
    // Set value
    $_SESSION["one"] = "one";
    $_SESSION["two"] = "two";
    $me = new Person("Amer", 20, 2892700);
    $_SESSION["name"] = $me->get_name();
    // Print output
    echo "Testing " .
        $_SESSION["one"] .
        ", " .
        $_SESSION["two"] .
        ", " .
        $me->get_number() .
        " . . .<br/>\n";
    ?>
</body>

</html>