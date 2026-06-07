<?php
require_once "book.php";

$pdo = new PDO(
    "mysql:host=localhost;dbname=library;charset=utf8mb4",
    "officer",
    "comp@exam"
);

$books = [];

if (isset($_GET["id"])) {

    if (empty($_GET["id"])) {
        header("Location: search.html");
        exit();
    }

    $sql = "SELECT * FROM books WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":id" => $_GET["id"]
    ]);

    $books = $stmt->fetchAll(PDO::FETCH_CLASS, "Book");

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["bookSearch"])) {
        header("Location: search.html");
        exit();
    }

    $sql = "SELECT * FROM books
            WHERE title LIKE :search
               OR subject LIKE :search
               OR authors LIKE :search";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":search" => "%" . $_POST["bookSearch"] . "%"
    ]);

    $books = $stmt->fetchAll(PDO::FETCH_CLASS, "Book");

} else {
    header("Location: search.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>

<?php if (count($books) == 0): ?>

<p>No records have been found that match the search criteria.</p>

<?php else: ?>

<table border="1">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Subject</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>

    <?php foreach ($books as $book): ?>
        <tr>
            <td>
                <a href="search.php?id=<?php echo htmlspecialchars($book->id); ?>">
                    <?php echo htmlspecialchars($book->title); ?>
                </a>
            </td>
            <td><?php echo htmlspecialchars($book->authors); ?></td>
            <td><?php echo htmlspecialchars($book->subject); ?></td>
            <td><?php echo htmlspecialchars($book->quantity); ?></td>
            <td><?php echo htmlspecialchars($book->price); ?></td>
        </tr>
        
    <?php endforeach; ?>
</table>

<?php endif; ?>

</body>
</html>