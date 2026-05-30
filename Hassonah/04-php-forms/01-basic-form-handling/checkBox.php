<!DOCTYPE html>


<html>
<head>
<title> submit check box as an Array</title>
</head>
<body>
<?php
// Form example
if (isset($_POST["part"])) {
    echo "<h3>Last Burger</h3>\n";
    echo "<ul>\n";
    foreach ($_POST["part"] as $choice) {
        echo "<li>$choice</li>\n";
    }

    echo "</ul>\n";
}

$option = ["mustard", "ketchup", "pickles", "onions", "lettuce", "tomato"];
?>
   <h3>Create a Burger</h3>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method ="post">
    <?php
    foreach ($option as $o): ?>
                        <input type="checkbox"  name="part[]" value="<?= $o ?>"> <?= $o ?> </input>
      <br/>
    <?php

        endforeach; ?>
   <input type="submit">
   </form>
   </body>
  </html>