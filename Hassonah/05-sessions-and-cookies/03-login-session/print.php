<?php
// Session/cookie example
// Start session
session_start();

if (isset($_SESSION["type"])) {
    // Choose case
    switch ($_SESSION["type"]) {
        // Case option
        case 1:
            // Send header
            header("Location: tmp/cust.php");
            break;
        // Case option
        case 2:
            // Send header
            header("Location: tmp/prog.php");
            break;
        // Case option
        case 3:
            // Send header
            header("Location: tmp/man.php");
            break;
        // Case option
        default:
            // Send header
            header("Location: session_login_index.php");
            break;
    }
} else {
    // Send header
    header("Location: session_login_index.php");
}
?>
