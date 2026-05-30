<?php
// Session/cookie example
// Start session
session_start(); ?>
<?php

if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    $_SESSION["referrer"] = "session_login_index.php";

    // Send header
    header("Location: logout.php");

} elseif (!isset($_SESSION["logged_in"])) {
    $_SESSION["referrer"] = "session_login_index.php";

    // Send header
    header("Location: loginV2.php");

} else {
    $_SESSION["visits"]++;

    // Send header
    header("Location: print.php");

} ?>
