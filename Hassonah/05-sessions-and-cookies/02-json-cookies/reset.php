<?php
// Session/cookie example
// Delete the cookie by setting expiration to the past
// Set cookie
setcookie("user_data", "", time() - 3600, "/");

// Redirect back to main page
// Send header
header("Location: index.php");
// Stop script
exit();
?>