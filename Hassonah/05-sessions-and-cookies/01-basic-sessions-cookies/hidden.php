<!-- File overview:
- What it does: This file demonstrates passing hidden/request values between pages.
- How to read it: Watch where PHP starts a session, sets a cookie, reads saved data, and decides what to display.
- Expected output: The browser output changes based on saved session or cookie values. -->
<!-- Purpose: Sessions and cookies example. PHP stores or reads browser state, then renders the current result. -->
<html>

<head></head>

<body>
    <?php
    // Output: No direct browser output.
// Explanation: Assigns, updates, increments, or decrements a stored value.
    $Message1 = "Bugs Bunny";
    // Output: No direct browser output.
// Explanation: Assigns, updates, increments, or decrements a stored value.
    $Message2 = "Homer Simpson";
    // Output: No direct browser output.
// Explanation: Assigns, updates, increments, or decrements a stored value.
    $Message3 = "Ren & Stimpy";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<form method='GET' action='hidden2.php'>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "Which of the following would win in a shootout?";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo " <select name='ListBox'>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<option SELECTED>Choose Your Message</option>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<option>$Message1</option>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<option>$Message2</option>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<option>$Message3</option>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "</select><br><br>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<input type='hidden' name='Hidden1' value='$Message1'>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<input type='hidden' name='Hidden2' value='$Message2'>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<input type='hidden' name='Hidden3' value='$Message3'>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "<input type='submit' value='Submit'>";
    // Output: Prints the specified text/HTML into the browser response.
// Explanation: Sends dynamic content from PHP to the generated page.
    echo "</form>";
    ?>
</body>

</html>