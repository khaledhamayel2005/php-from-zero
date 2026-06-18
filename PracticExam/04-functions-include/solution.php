<?php
require_once "functions.inc.php";

$books = array(
    array("title" => "PHP Basics", "author" => "Connolly", "price" => 30, "discount" => 10),
    array("title" => "HTML Guide", "author" => "Hoar", "price" => 20, "discount" => 5),
    array("title" => "Database Intro", "author" => "Smith", "price" => 40, "discount" => 15),
);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Books</title>
  </head>
  <body>
    <h1>Books</h1>
    <table border="1" cellpadding="6">
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
        <th>Discount</th>
        <th>New Price</th>
      </tr>
      <?php
      foreach ($books as $book) {
          displayBookRow($book);
      }
      ?>
    </table>
  </body>
</html>

