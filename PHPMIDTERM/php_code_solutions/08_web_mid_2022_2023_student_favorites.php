<?php
/*
Exam: Web Midterm Second Semester 2022/2023
Source: PHPMIDTERM/PDF/Web-Midterm-Second-Semester-2022_2023_bkWTA7F_Y8j1CDw.pdf

This file contains the PHP-related code questions:
1. A student favorites form and stFavorites.php.
2. message.php that creates and reads a course cookie.
*/

/*
Question 2:
Create student.html with a form for firstName, familyName, stID, email, and
favoriteSubjects. Submit by POST to stFavorites.php.
*/
function studentHtmlForm(): string
{
    return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Student Info</title>
</head>
<body>
    <form id="studentInfo" method="post" action="https://birzeit.edu.ps/students/stFavorites.php">
        <fieldset>
            <legend>Student</legend>

            <label>First name
                <input type="text" name="firstName" pattern="[A-Za-z]+" required>
            </label><br>

            <label>Family name
                <input type="text" name="familyName" pattern="[A-Za-z]+" required>
            </label><br>

            <label>Student ID
                <input type="text" name="stID" pattern="[0-9]{10}" required>
            </label><br>

            <label>Email
                <input type="email" name="email" required>
            </label><br>

            <label>Favorite subjects</label><br>
            <select name="favoriteSubjects[]" multiple required>
                <option value="Algorithms">Algorithms</option>
                <option value="Compiler">Compiler</option>
                <option value="Networks">Networks</option>
                <option value="Web Programming">Web Programming</option>
            </select><br>

            <button type="submit">Submit</button>
        </fieldset>
    </form>
</body>
</html>
HTML;
}

/*
Question 3:
Write stFavorites.php. Connect to database stInfo using PDO and named
parameters. Store student details. If the student exists, append the new
favorite subject to the Favorites table. If no data was sent, redirect to
student.html.
*/
function handleStudentFavorites(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: student.html');
        exit;
    }

    $student = [
        'stID' => trim($_POST['stID'] ?? ''),
        'stFname' => trim($_POST['firstName'] ?? ''),
        'stLname' => trim($_POST['familyName'] ?? ''),
        'stEmail' => trim($_POST['email'] ?? ''),
    ];
    $subjects = $_POST['favoriteSubjects'] ?? [];

    $pdo = new PDO(
        'mysql:host=stdata.birzeit.ps.edu;dbname=stInfo;charset=utf8mb4',
        'admin',
        'comp334',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    // Insert the student only if the ID is not already stored.
    $stmt = $pdo->prepare(
        'INSERT IGNORE INTO Student (stID, stFname, stLname, stEmail)
         VALUES (:stID, :stFname, :stLname, :stEmail)'
    );
    $stmt->execute($student);

    // Append each selected subject to Favorites.
    $favoriteStmt = $pdo->prepare(
        'INSERT INTO Favorites (stID, subjectName)
         VALUES (:stID, :subjectName)'
    );

    foreach ($subjects as $subject) {
        $favoriteStmt->execute([
            'stID' => $student['stID'],
            'subjectName' => $subject,
        ]);
    }

    $listStmt = $pdo->prepare(
        'SELECT subjectName FROM Favorites WHERE stID = :stID ORDER BY subjectName'
    );
    $listStmt->execute(['stID' => $student['stID']]);
    $favorites = $listStmt->fetchAll(PDO::FETCH_COLUMN);

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>Favorites</title></head><body>';
    echo '<p>Dear ' . htmlspecialchars($student['stFname']) . ' your favorite subjects are:</p>';
    echo '<ul>';
    foreach ($favorites as $favorite) {
        echo '<li>' . htmlspecialchars($favorite) . '</li>';
    }
    echo '</ul></body></html>';
}

/*
Question 4:
Write message.php. Create a cookie named "course" with value "COMP334".
On the first request, show a figure with COMP334.jpeg and a reload link.
On reload, show the course welcome message and cookie value.
*/
function renderCourseMessage(): void
{
    $cookieName = 'course';
    $cookieValue = 'COMP334';

    if (!isset($_COOKIE[$cookieName])) {
        // Cookie is available to PHP on the next request.
        setcookie($cookieName, $cookieValue, time() + 3600, '/');

        echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
        echo '<title>COMP334 Course</title></head><body>';
        echo '<figure>';
        echo '<img src="COMP334.jpeg" alt="COMP334 Course">';
        echo '<figcaption>COMP334 Course</figcaption>';
        echo '</figure>';
        echo '<p><a href="message.php">Page Reload</a></p>';
        echo '</body></html>';
        return;
    }

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>COMP334 Course</title></head><body>';
    echo '<h1>Welcome to COMP 334 Course Main Page</h1>';
    echo '<p>Cookie course has value ' . htmlspecialchars($_COOKIE[$cookieName]) . '</p>';
    echo '</body></html>';
}
