<?php
// Session/cookie example
// Start session
session_start();
// Load file
include "../dbcon.inc";
if (isset($_SESSION["userid"])) {
    $username = $_SESSION["userid"];
    // Page layout
    html_header();
    echo "Hello " . $username . "<br/>";
    echo "you are a Manager" . "<br/>";
    echo "you have visited this page" .
        $_SESSION["visits"]++ .
        " times" .
        "<br/>";
    echo "<a href = \"http://localhost/comp334\" target =\"msgWin\"> Course Page</a><br/>";

    echo "<a href=\"../logout.php\">log out</a>";
    // Page layout
    html_footer();
}
?>
