<?php
/*
 * File overview:
- What it does: This file demonstrates creating, reading, updating, or clearing browser cookies.
- How to read it: Watch where PHP starts a session, sets a cookie, reads saved data, and decides what to display.
- Expected output: The browser output changes based on saved session or cookie values.
 */
/*
 * Purpose: Sessions and cookies example. PHP stores or reads browser state, then renders the current result.
 */



if (!empty($_POST["type_sel"])) {
    $type = $_POST["type_sel"];

    // Output: Sends a Set-Cookie header to the browser; no visible HTML is printed by this line.
    // Explanation: Stores or updates a browser cookie value for later requests.
    setcookie("Type", $type, time() + 3600);
}



if (!empty($_POST["size_sel"])) {
    $size = $_POST["size_sel"];
    // Output: Sends a Set-Cookie header to the browser; no visible HTML is printed by this line.
    // Explanation: Stores or updates a browser cookie value for later requests.
    setcookie("Size", $size, time() + 3600);
}

//We define some options for font size and typeface, and as it's now safe to add an //HTML header, we do so:
// Output: No direct browser output.
// Explanation: Assigns, updates, increments, or decrements a stored value.
$type = ["arial", "helvetica", "sans-serif", "courier"];
// Output: No direct browser output.
// Explanation: Assigns, updates, increments, or decrements a stored value.
$size = ["1", "2", "3", "4", "5", "6", "7"];
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<html><head><title>Cookie Test</title></head><body><div align='center'>";

//The following form contains a pair of listboxes, which can be used to specify the //user's preferences:
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<form method='POST'>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "What font type would you like to use? ";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<select name='type_sel'>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<option selected value=''>default</option>";
// Output: No direct browser output.
// Explanation: Loops through each item in the array or collection.
foreach ($type as $var) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "<option>$var</option>";
}
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "</select><br><br>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "What font size would you like to use? ";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<select name='size_sel'>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<option selected value=''>default</option>";

// Output: No direct browser output.
// Explanation: Loops through each item in the array or collection.
foreach ($size as $var) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "<option>$var</option>";
}
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "</select><br><br>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<input type='submit'>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "</form>";

//Finally, we echo out some useful information, and format it using appropriate //settings:
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<b>Your cookies say:</b><br>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<font ";
// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_COOKIE["Type"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "face='$_COOKIE[Type]' ";
}

// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_COOKIE["Size"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "size='$_COOKIE[Size]' ";
}
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo ">";
// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_COOKIE["Type"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "Type = $_COOKIE[Type]";
}
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<br>";
// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_COOKIE["Size"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "Size = $_COOKIE[Size]";
}
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "</font><br>";

// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<b>Your form variables say:</b><br>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "<font ";

// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_POST["type_sel"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "face='$_POST[type_sel]' ";
}

// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_POST["size_sel"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "size='$_POST[size_sel]' ";
}
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo ">";
// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_POST["type_sel"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "Type = $_POST[type_sel]<br>";
}
// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_POST["size_sel"])) {
    // Output: Prints the specified text/HTML into the browser response.
    // Explanation: Sends dynamic content from PHP to the generated page.
    echo "Size = $_POST[size_sel]<br>";
}
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "</font>";
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
echo "</div></body></html>";
?>