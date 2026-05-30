<!DOCTYPE html>


<html>
  <head>
  	<title>Example</title>
  </head>
  <body>
  <?php
  // Array/form example
  function printForm()
  {
      ?>

      
  <form action="welcome.php" method="post">
  Enter your name: <input type="text" name="name" /> <br/>
  Enter your age: <input type="text" name="age" /> <br/>
  Enter your ID: <input type="text" name="id" /> <br/>
  <input type="submit" /> <input type="reset" />
  </form>
  <?php

  }
  echo "<h6> Wrong Input, please enter a valid Input !! </h6>";
  printForm();
  ?>
  </body>
</html>
