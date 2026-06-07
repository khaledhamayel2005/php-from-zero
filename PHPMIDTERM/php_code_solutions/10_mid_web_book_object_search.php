<?php
/*
Exam: Mid-Web mixed PHP questions
Sources:
- PHPMIDTERM/PDF/Mid-Web_oOtsjef_ok5COFV.pdf
- /home/hamail/Downloads/php code forms M.pdf

This file contains the book.html form, the Book class question, and the related
search.php question.
*/

/*
Question Two:
Create a static HTML page called book.html. It must contain a form with id
bookSearch, use fieldset and legend, send POST data to
https://birzeit.edu.ps/lib/search.php, and include mandatory inputs bookTitle,
bookAuthor, and subjects. Use labels and HTML5 validation.
*/
function bookSearchFormHtml(): string
{
    return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Book Search</title>
</head>
<body>
    <form id="bookSearch" method="post" action="https://birzeit.edu.ps/lib/search.php">
        <fieldset>
            <legend>Book Search</legend>

            <label for="bookTitle">Book title</label>
            <input id="bookTitle" type="text" name="bookTitle" pattern="[A-Za-z ]+" required>
            <br>

            <label for="bookAuthor">Book author</label>
            <input id="bookAuthor" type="text" name="bookAuthor" pattern="[A-Za-z ]+" required>
            <br>

            <label for="subjects">Subject</label>
            <select id="subjects" name="subjects" required>
                <option value="" disabled selected>Select a subject</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Physics">Physics</option>
                <option value="Civil Engineering">Civil Engineering</option>
            </select>
            <br>

            <button type="submit">Search</button>
        </fieldset>
    </form>
</body>
</html>
HTML;
}

/*
Question Three:
Write book.php to define the Book class. The class has bookID, bookTitle,
bookSubject, bookAuthor, BookQuantity, and price. Write getURL() to return an
HTML link to search.php with the book ID in the query string. Write
getBookInfo() to return one HTML table row with title, author, subject,
quantity, and price. The title should be linked.
*/
class Book
{
    private int $bookID;
    private string $bookTitle;
    private string $bookSubject;
    private string $bookAuthor;
    private int $bookQuantity;
    private float $price;

    public function __construct(
        int $id,
        string $title,
        string $subject,
        string $author,
        int $quantity,
        float $price
    ) {
        $this->bookID = $id;
        $this->bookTitle = $title;
        $this->bookSubject = $subject;
        $this->bookAuthor = $author;
        $this->bookQuantity = $quantity;
        $this->price = $price;
    }

    public function getURL(): string
    {
        // Return the link instead of echoing it.
        return '<a href="search.php?id=' . urlencode((string) $this->bookID) . '">'
            . htmlspecialchars($this->bookTitle)
            . '</a>';
    }

    public function getBookInfo(): string
    {
        return '<tr>'
            . '<td>' . $this->getURL() . '</td>'
            . '<td>' . htmlspecialchars($this->bookAuthor) . '</td>'
            . '<td>' . htmlspecialchars($this->bookSubject) . '</td>'
            . '<td>' . htmlspecialchars((string) $this->bookQuantity) . '</td>'
            . '<td>' . htmlspecialchars(number_format($this->price, 2)) . '</td>'
            . '</tr>';
    }
}

/*
Question Four:
Write search.php. Database: library on localhost, user maher, password
comp@exam. Table books(id, title, subject, authors, quantity, price).
If POST data is sent by bookSearch, use PDO and a prepared statement to fetch
matching books as Book objects and display them in a table. If no records are
found, display a message. If the query string is empty, redirect to
search_book.html. If a book ID is sent by GET, display one row with its details.
*/
function libraryConnection(): PDO
{
    return new PDO(
        'mysql:host=localhost;dbname=library;charset=utf8mb4',
        'maher',
        'comp@exam',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}

function bookFromRow(array $row): Book
{
    return new Book(
        (int) $row['id'],
        $row['title'],
        $row['subject'],
        $row['authors'],
        (int) $row['quantity'],
        (float) $row['price']
    );
}

function renderBookRows(array $books): void
{
    echo '<table border="1" cellpadding="6">';
    echo '<tr><th>Title</th><th>Author</th><th>Subject</th><th>Quantity</th><th>Price</th></tr>';
    foreach ($books as $book) {
        echo $book->getBookInfo();
    }
    echo '</table>';
}

function runBookSearchPage(): void
{
    $pdo = libraryConnection();
    $books = [];

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET)) {
        header('Location: search_book.html');
        exit;
    }

    if (isset($_GET['id'])) {
        // Show details for exactly one selected book.
        $stmt = $pdo->prepare(
            'SELECT id, title, subject, authors, quantity, price
             FROM books
             WHERE id = :id'
        );
        $stmt->execute(['id' => $_GET['id']]);
        $row = $stmt->fetch();
        $books = $row ? [bookFromRow($row)] : [];
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['bookTitle'] ?? '');
        $author = trim($_POST['bookAuthor'] ?? '');

        $stmt = $pdo->prepare(
            'SELECT id, title, subject, authors, quantity, price
             FROM books
             WHERE title LIKE :title AND authors LIKE :author
             ORDER BY title ASC'
        );
        $stmt->execute([
            'title' => '%' . $title . '%',
            'author' => '%' . $author . '%',
        ]);

        foreach ($stmt as $row) {
            $books[] = bookFromRow($row);
        }
    }

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>Book Search Answer</title></head><body>';

    if (empty($books)) {
        echo '<p>No records match the search criteria.</p>';
    } else {
        renderBookRows($books);
    }

    echo '</body></html>';
}
