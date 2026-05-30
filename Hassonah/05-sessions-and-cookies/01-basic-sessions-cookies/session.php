<?php
/*
 * File overview:
- What it does: This file demonstrates session storage and session-based page behavior.
- How to read it: Watch where PHP starts a session, sets a cookie, reads saved data, and decides what to display.
- Expected output: The browser output changes based on saved session or cookie values.
 */
/*
 * Purpose: Sessions and cookies example. PHP stores or reads browser state, then renders the current result.
 */
//start session
// Output: Starts or resumes a session; it may send a session cookie header but prints no visible HTML.
// Explanation: Makes $_SESSION available for storing user-specific data.
session_start();

//Set variable based on form input
// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_REQUEST["inputName"])) {
    // Output: No direct browser output.
    // Explanation: Assigns, updates, increments, or decrements a stored value.
    $_SESSION["Name"] = $_REQUEST["inputName"];
}

//Increment counter with each page load
// Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
if (isset($_SESSION["Count"])) {
    // Output: No direct browser output.
    // Explanation: Assigns, updates, increments, or decrements a stored value.
    $_SESSION["Count"]++;
    // Output: No direct browser output.
// Explanation: Starts the fallback branch when the previous condition is false.
} else {
    //start with count of 1
    // Output: No direct browser output.
    // Explanation: Assigns, updates, increments, or decrements a stored value.
    $_SESSION["Count"] = 1;
}
?>
<html>

<head>
    <title>Listing 7-6</title>
</head>

<body>
    <?php
    //print diagnostic info
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "<b>Diagnostic Information</b><br>\n";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "Session Name: " . session_name() . "<br>\n";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "Session ID: " . session_id() . "<br>\n";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "Session Module Name: " . session_module_name() . "<br>\n";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "Session Save Path: " . session_save_path() . "<br>\n";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "Encoded Session:" . session_encode() . "<br>\n";

    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "<hr>\n";

    // Output: No direct browser output.
// Explanation: Checks a condition and runs the following block only when it is true.
    if (isset($_SESSION["Name"])) {
        // Output: Prints the specified text/HTML into the browser response.
        // Explanation: Sends dynamic content from PHP to the generated page.
        print "Hello, {$_SESSION["Name"]}!<br>\n";
    }

    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "You have viewed this page " . $_SESSION["Count"] . " times!<br>\n";
    //show form for getting name
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "<form " .
        // Output: No direct browser output.
        // Explanation: Continues the current PHP expression or block.
        "action=\"{$_SERVER["PHP_SELF"]}\" " .
        // Output: No direct browser output.
        // Explanation: Continues the current PHP expression or block.
        "method=\"post\">" .
        // Output: No direct browser output.
        // Explanation: Continues the current PHP expression or block.
        "<input type=\"text\" name=\"inputName\" " .
        // Output: No direct browser output.
        // Explanation: Continues the current PHP expression or block.
        "value=\"\"><br>\n" .
        // Output: No direct browser output.
        // Explanation: Continues the current PHP expression or block.
        "<input type=\"submit\" value=\"change name\"><br>\n" .
        // Output: No direct browser output.
        // Explanation: Runs this PHP statement as part of the script flow.
        "</form>";

    //use a link to reload this page
// Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    print "<a href=\"{$_SERVER["PHP_SELF"]}\">reload</a><br>\n";
    ?>
</body>

</html>