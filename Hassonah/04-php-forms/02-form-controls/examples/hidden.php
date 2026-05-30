<html>
<head></head>
<body>
<?php
// Form example
$Messase1 = "Bugs Bunny";
$Message2 = "Homer Simpson";
$Message3 = "Ren & Stimpy";
echo "<form method='GET' action='hidden2.php'>";
echo "Which of the following would win in a shootout?";
echo " <select name='ListBox'>";
echo "<option>$Message1</option>";
echo "<option>$Message2</option>";
echo "<option>$Message3</option>";
echo "</select><br><br>";
echo "<input type='hidden' name='Hidden1' value='$Messase1'>";
echo "<input type='hidden' name='Hidden2' value='$Message2'>";
echo "<input type='hidden' name='Hidden3' value='$Message3'>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
?>
</body>
</html>

