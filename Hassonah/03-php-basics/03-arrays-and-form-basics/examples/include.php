<html>
   <head>
      <title> Include Example</title>
   </head>
<!-- include.php -->
<body>

<?php
// Array/form example
function foo()
{
    global $color;

    // Load file
    include "vars.php";

    echo "<h3>A $color $fruit <h3>";
}

/* vars.php is in the scope of foo() so    *
 * $fruit is NOT available outside of this  *
 * scope.  $color is because we declared it *
 * as global.                              */

foo();
// A green apple
echo "<h3> A $color $fruit <h3>"; // A green

foo();
?>

</body>
</html>
