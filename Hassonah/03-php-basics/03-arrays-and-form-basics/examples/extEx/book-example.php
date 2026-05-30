<?php
// Array/form example
// Load file
include "book-data.inc.php";
// has the user selected a book to display?
if (isset($_GET["isbn"])) {
    $isbn = $_GET["isbn"];
    // ensure we have this isbn in our data
    if (!array_key_exists($isbn, $books)) {
        $isbn = $defaultISBN;
    }
} else {
    // If none is selected, display the first book in the list
    $isbn = $defaultISBN;
}
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<main>
<nav>
<ul>
<?php
foreach ($books as $key => $value) {
    echo "<li>";
    echo '<a href="book-example.php?isbn=' . $key . '">';
    echo $value["title"];
    echo "</a>";
    echo "</li>";
} ?>
</ul>
</nav>
<section>
<ul>
<li> Title: <?= $books[$isbn]["title"] ?></li>
<li>ISBN: <?= $isbn ?></li>
<li>Year: </span><?= $books[$isbn]["year"] ?></li>
<li>Pages: </span><?= $books[$isbn]["pages"] ?></li>
<li> Description: <?= $books[$isbn]["description"] ?></li>
</ul>
</section>
</body>
</html>
