<?php
// Session/cookie example
// Start session
session_start();
// Load file
include "dbcon.inc";
$CookieInfo = session_get_cookie_params();
if (empty($CookieInfo["domain"]) && empty($CookieInfo["secure"])) {
    // Set cookie
    setcookie(session_name(), "", time() - 3600, $CookieInfo["path"]);
} elseif (empty($CookieInfo["secure"])) {
    // Set cookie
    setcookie(
        session_name(),
        "",
        time() - 3600,
        $CookieInfo["path"],
        $CookieInfo["domain"],
    );
} else {
    // Set cookie
    setcookie(
        session_name(),
        "",
        time() - 3600,
        $CookieInfo["path"],
        $CookieInfo["domain"],
        $CookieInfo["secure"],
    );
}
unset($_COOKIE[session_name()]);
$t = $_SESSION["referrer"];
session_destroy();

// Page layout
html_header();
echo 'Good Bye and Come back <hr/><a href = "' . $t . '">Log In </a>';
// Page layout
html_footer();
?>
