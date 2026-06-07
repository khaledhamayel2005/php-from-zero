<?php
/*
Exam: Old Midterm
Source: PHPMIDTERM/PDF/Old_Midterm__y9MYPz1_wOvCQ0N.pdf

Question:
Library books are stored in a database. Each book has one category. If a user
chooses a category, show all books in that category using author and title,
sorted by author then title. The Book table has:
isbn, author, title, description, publication_date, category.
For the middle page, write the PHP server-side code that obtains the list of
books and displays it using HTML.
*/

$category = trim($_POST['category'] ?? $_GET['category'] ?? '');

if ($category === '') {
    header('Location: categories.html');
    exit;
}

try {
    // Credentials were not visible in the scan, so these are simple placeholders.
    $pdo = new PDO(
        'mysql:host=localhost;dbname=library;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $stmt = $pdo->prepare(
        'SELECT isbn, author, title
         FROM Book
         WHERE category = :category
         ORDER BY author ASC, title ASC'
    );
    $stmt->execute(['category' => $category]);
    $books = $stmt->fetchAll();
} catch (PDOException $e) {
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Books by Category</title>
</head>
<body>
    <h1>Books in <?= htmlspecialchars($category) ?></h1>

    <?php if (empty($books)): ?>
        <p>No books were found in this category.</p>
    <?php else: ?>
        <table border="1" cellpadding="6">
            <tr>
                <th>Author</th>
                <th>Title</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td>
                        <!-- Link to the details page using the ISBN. -->
                        <a href="book_details.php?isbn=<?= urlencode($book['isbn']) ?>">
                            <?= htmlspecialchars($book['title']) ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
