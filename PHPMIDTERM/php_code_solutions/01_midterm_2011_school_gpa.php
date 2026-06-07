<?php
/*
Exam: Midterm 2011
Source: PHPMIDTERM/PDF/Midterm_2011_lI1jNae_mJJs6pk.pdf

Question:
Assume there is a "school" database on localhost with username "test" and
password "test". The database contains a student table:
student(studentid int, name char(20), gpa number(2,1)).
Write a script that displays students in a table, adds a form to filter by
"GPA greater than", and sorts the list by GPA.
*/

session_start();

$dsn = 'mysql:host=localhost;dbname=school;charset=utf8mb4';
$username = 'test';
$password = 'test';

$minimumGpa = filter_input(INPUT_POST, 'gpa', FILTER_VALIDATE_FLOAT);
$minimumGpa = $minimumGpa === false || $minimumGpa === null ? 0 : $minimumGpa;

try {
    // Connect using PDO and show database errors as exceptions.
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Use a prepared statement so the GPA value is safe.
    $stmt = $pdo->prepare(
        'SELECT studentid, name, gpa
         FROM student
         WHERE gpa > :gpa
         ORDER BY gpa ASC'
    );
    $stmt->execute(['gpa' => $minimumGpa]);
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Students GPA Filter</title>
</head>
<body>
    <table border="1" cellpadding="6">
        <tr>
            <th>Student id</th>
            <th>Name</th>
            <th>GPA</th>
        </tr>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars((string) $student['studentid']) ?></td>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= htmlspecialchars((string) $student['gpa']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <p>
            <label>
                GPA greater than:
                <input type="number" name="gpa" min="0" max="4" step="0.1"
                       value="<?= htmlspecialchars((string) $minimumGpa) ?>">
            </label>
        </p>
        <button type="submit">Filter</button>
    </form>
</body>
</html>
