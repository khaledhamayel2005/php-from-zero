<?php
// Session/cookie example
// Start session
session_start();
// Check condition
if (isset($_POST["end"])) {
    // Send header
    header("Location: done.php");
}

// Check condition
if (!isset($_SESSION["pages"])) {
    // Set value
    $_SESSION["pages"] = [1 => 0];
}
?>
<?php


// Define function
function printForm()
{
    // Print output
    echo <<<DONE
    <form  action ="{$_SERVER["PHP_SELF"]}"  method = "post">
    <input type = "submit" name="end" value ="End Session" >
    </form>
    DONE;

} //The rest of the script illustrates how to make hyperlinks that hand PHP what it needs to access your session data - namely, SID.
// Print output
echo "<html><head><title>Web Page Hit Counter</title></head><body>";

// Check condition
if (isset($_GET["whichpage"])) {
    // Print output
    echo "<b>You are currently on page $_GET[whichpage].</b><br><br>\n";

    $_SESSION["pages"][$_GET["whichpage"]]++;

}

// Loop values
for ($i = 1; $i <= 4; $i++) {
    // Check condition
    if (isset($_GET["whichpage"]) == $i) {
        // Print output
        echo "<b><a href=\"sessions.php?" .

            // Call function
            session_id() .
            "&whichpage=$i\">Page $i</a></b>";

        // Else branch
    } else {
        // Print output
        echo "<a href=\"sessions.php?" .

            // Call function
            session_id() .
            "&whichpage=$i\">Page $i</a>";

    }

    // Check condition
    if (!isset($_SESSION["pages"][$i])) {
        $_SESSION["pages"][$i] = 0;

    }

    // Print output
    echo ", which you have chosen " . $_SESSION["pages"][$i] . " times.<BR>\n";

}

// Print output
echo "\n\n<br><br>\n\n";

// Call function
printForm();

// Print output
echo "</body></html>";
?>