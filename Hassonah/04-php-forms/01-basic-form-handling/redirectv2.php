<?php
// Form example
if (!isset($_GET["id"])) {
    // Send header
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    // Stop script
    exit();
} else {
     ?>
  <html>
  <!DOCTYPE html>
  <html>
    <head>
    	<title>Redirect example</title>
    </head>
    <body>
    	 <p>Redirect example, try this link without query string,
                                    <a href ="<?php echo $_SERVER[
             "PHP_SELF"
         ]; ?>">invlid input (empty quest string)</a>and you will get 404 eror</p>
    </body>
  </html>
<?php

}
?>
