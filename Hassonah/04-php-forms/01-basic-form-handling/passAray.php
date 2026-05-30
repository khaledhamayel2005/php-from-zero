<?php
// Form example
print "<html>\n";
print "<head>\n";
print "<title>passing array</title>\n";
print "</head>\n";

print "<body>\n";

if (isset($_POST["part"])) {
    print "<h3>Last Burger</h3>\n";
    print "<ul>\n";
    $arr = $_POST["part"];
    foreach ($arr as $choice) {
        print "<li>$choice</li>\n";
    }

    print "</ul>\n";
}

$option = ["mustard", "ketchup", "pickles", "onions", "lettuce", "tomato"];

print "<h3>Create a Burger</h3>\n";
print "<form action=\"{$_SERVER["PHP_SELF"]}\" method =\"post\">\n";
foreach ($option as $o) {
    print "<input type=\"checkbox\" " .
        "name=\"part[]\" value=\"$o\">" .
        "$o<br>\n";
}

print "<input type=\"submit\">\n";
print "</form>\n";

print "</body>\n";
print "</html>\n";
?>
