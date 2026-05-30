<?php
// Session/cookie example
// Start session
session_start();

// Initialize session values
if (!isset($_SESSION["a"])) {
    print "Initializing Session<br>";

    $_SESSION["a"] = "Session Var A";
    $_SESSION["b"] = 123.45;
    $_SESSION["c"] = 0;
}

// Update access count
$_SESSION["c"]++;

print "Access count: " . $_SESSION["c"] . "<br>";

print "Session Dump: " . session_encode() . "<br>";
?>
