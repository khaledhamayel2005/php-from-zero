<?php
// Session/cookie example
/*
 ** mark this site as being visited
 ** for the next 24 hours
 */

if (isset($_COOKIE["HasVisitedLast24Hours"])) {
    echo "You have visted us within the last 24 hours";
    echo $_COOKIE["HasVisitedLast24Hours"];
    $a = ++$_COOKIE["HasVisitedLast24Hours"];
    // Set cookie
    setcookie("HasVisitedLast24Hours", $a, time() + 86400);
} else {
    echo "Welcome to our website";
    // Set cookie
    setcookie("HasVisitedLast24Hours", 1, time() + 86400);
}
?>
