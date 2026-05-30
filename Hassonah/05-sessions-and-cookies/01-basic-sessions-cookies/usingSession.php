<?php
// Session/cookie example
//start session
// Start session
session_start();

//Set variable based on form input
// Check condition
if (isset($_REQUEST["inputName"])) {
    // Set value
    $_SESSION["Name"] = $_REQUEST["inputName"];
}

//Increment counter with each page load
// Check condition
if (isset($_SESSION["Count"])) {
    // Set value
    $_SESSION["Count"]++;
    // Else branch
} else {
    //start with count of 1
    // Set value
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
// Print output
    print "<b>Diagnostic Information</b><br>\n";
    print "Session Name: " . session_name() . "<br>\n";
    print "Session ID: " . session_id() . "<br>\n";
    print "Session Module Name: " . session_module_name() . "<br>\n";
    print "Session Save Path: " . session_save_path() . "<br>\n";
    print "Encoded Session:" . session_encode() . "<br>\n";

    // Print output
    print "<hr>\n";

    // Check condition
    if (isset($_SESSION["Name"])) {
        // Print output
        print "Hello, {$_SESSION["Name"]}!<br>\n";
    }

    // Print output
    print "You have viewed this page " . $_SESSION["Count"] . " times!<br>\n";
    //show form for getting name
    print "<form " .
        "action=\"{$_SERVER["PHP_SELF"]}\" " .
        "method=\"post\">" .
        "<input type=\"text\" name=\"inputName\" " .
        "value=\"\"><br>\n" .
        "<input type=\"submit\" value=\"change name\"><br>\n" .
        "</form>";

    //use a link to reload this page
// Print output
    print "<a href=\"{$_SERVER["PHP_SELF"]}\">reload</a><br>\n";
    ?>
</body>

</html>