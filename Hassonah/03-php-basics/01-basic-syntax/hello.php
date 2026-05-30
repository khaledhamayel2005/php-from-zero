<html>
<!-- hello.php COMP334 -->
<head><title>Hello World</title></head>
<body>
  <p>This is going to be ignored by the PHP interpreter.</p>

   <?php
   // PHP basics example
   echo "<p>While this is going to be parsed.</p>"; ?>

  <p>This will also be ignored.</p>

   <?php
   print "<p>Hello and welcome to <i> my </i> page!</p>"; ?>

  <?php
  // This is a comment

  echo "<p>This will also be ignored.</p>";
/*
   This is
   a comment
   block
  */
?>

</body>
</html>
