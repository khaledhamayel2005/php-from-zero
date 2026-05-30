<!-- File overview:
- What it does: This file demonstrates a self-submitting form that posts back to the same PHP file.
- How to read it: Check the form fields, the request method, and the PHP variables used to read submitted values.
- Expected output: After submitting the form, PHP prints a response page or redirects the browser. -->
<!-- Purpose: PHP form-handling example. The form sends data to PHP, then PHP reads the request and prints output. -->
<html>

<head>
    <title>Simple input</title>
</head>

<?php
// if this is the first request
// use white for bgcolor
if (!isset($_POST["color"])) {
    $_POST["color"] = "FFFFFF";
}

// open body with background color
echo "<body bgcolor=\"#" . $_POST["color"] . "\">\n";

// start form, action is this page itself

echo "<form  action=\"{$_SERVER["PHP_SELF"]}\"  method=\"POST\">\n";

// ask for a color
echo "<b>HTML color:</b> <input type=\"text\" name=\"color\" value=\"{$_POST["color"]}\">\n";

// show submit button
echo "<input type=\"submit\" value=\"Try It\">\n";
?>

</form>
</body>

</html>