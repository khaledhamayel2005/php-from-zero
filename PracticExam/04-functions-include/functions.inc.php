<?php
function bookPriceAfterDiscount($price, $discount)
{
    return $price - ($price * $discount / 100);
}

function displayBookRow($book)
{
    $newPrice = bookPriceAfterDiscount($book["price"], $book["discount"]);
    echo "<tr>";
    echo "<td>" . htmlspecialchars($book["title"]) . "</td>";
    echo "<td>" . htmlspecialchars($book["author"]) . "</td>";
    echo "<td>" . $book["price"] . "</td>";
    echo "<td>" . $book["discount"] . "%</td>";
    echo "<td>" . $newPrice . "</td>";
    echo "</tr>";
}
?>

