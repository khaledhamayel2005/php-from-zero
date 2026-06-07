<?php
/*
Exam: Midterm 2017
Source: PHPMIDTERM/PDF/Midterm_2017_LRz6Td0.pdf

Question:
Suppose there is a database named "library" on localhost with username "root"
and password "123". The books table has book_id, title, status, authors, and
price columns. Create search_books.php so users can search by book title and/or
author. Retrieved books should be shown in a dynamic table with a "select" link.
When the user clicks select, add the book id and price to the session. Finally,
display the number of selected books and the total price.
*/

session_start();

if (!isset($_SESSION['selected_books'])) {
    $_SESSION['selected_books'] = [];
}

$dsn = 'mysql:host=localhost;dbname=library;charset=utf8mb4';
$username = 'root';
$password = '123';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Add selected book information to the session.
    if (isset($_GET['select'])) {
        $stmt = $pdo->prepare('SELECT book_id, price FROM books WHERE book_id = :id');
        $stmt->execute(['id' => $_GET['select']]);
        $selectedBook = $stmt->fetch();

        if ($selectedBook) {
            $_SESSION['selected_books'][$selectedBook['book_id']] = (float) $selectedBook['price'];
        }
    }

    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $books = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Search by title, author, or both.
        $stmt = $pdo->prepare(
            'SELECT book_id, title, status, authors, price
             FROM books
             WHERE title LIKE :title AND authors LIKE :author
             ORDER BY title ASC, authors ASC'
        );
        $stmt->execute([
            'title' => '%' . $title . '%',
            'author' => '%' . $author . '%',
        ]);
        $books = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}

$selectedCount = count($_SESSION['selected_books']);
$totalPrice = array_sum($_SESSION['selected_books']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Library Search</title>
</head>
<body>
    <form method="post" action="search_books.php">
        <label>
            Book title:
            <input type="text" name="title" value="<?= htmlspecialchars($title) ?>">
        </label>
        <label>
            Author:
            <input type="text" name="author" value="<?= htmlspecialchars($author) ?>">
        </label>
        <button type="submit">Search</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <table border="1" cellpadding="6">
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Authors</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars((string) $book['book_id']) ?></td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['status']) ?></td>
                    <td><?= htmlspecialchars($book['authors']) ?></td>
                    <td><?= htmlspecialchars((string) $book['price']) ?></td>
                    <td>
                        <a href="search_books.php?select=<?= urlencode((string) $book['book_id']) ?>">
                            select
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <section>
        <h2>Selected Books</h2>
        <p>Number of selected books: <?= $selectedCount ?></p>
        <p>Total price: <?= number_format((float) $totalPrice, 2) ?></p>
    </section>
</body>
</html>
