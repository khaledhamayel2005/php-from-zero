<?php
/*
Exam: Midterm 2014
Sources:
- PHPMIDTERM/PDF/Midterm_2014_aBzZasI.pdf
- PHPMIDTERM/PDF/Midterm_Exam_2014_Key_Y0W9fLF_L8206zc.pdf

Question:
Write a PHP script that allows the user to select a race year from a combo box.
After submission, display the cars that participated in that year. The list
must show Car Model, Driver, and Place, sorted by Place ascending. Store the
selected year in a session. Database: race, user: httpd, password: test,
server: localhost.
*/

session_start();

$dsn = 'mysql:host=localhost;dbname=race;charset=utf8mb4';
$username = 'httpd';
$password = 'test';

try {
    // Create one PDO connection for both the year list and the result list.
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $years = $pdo->query('SELECT DISTINCT RaceYear FROM cars ORDER BY RaceYear ASC')
        ->fetchAll(PDO::FETCH_COLUMN);

    if (isset($_POST['year'])) {
        $_SESSION['selected_year'] = $_POST['year'];
    }

    $selectedYear = $_SESSION['selected_year'] ?? ($years[0] ?? '');
    $cars = [];

    if ($selectedYear !== '') {
        // Fetch only cars from the selected year.
        $stmt = $pdo->prepare(
            'SELECT CarModel, Driver, Place
             FROM cars
             WHERE RaceYear = :year
             ORDER BY Place ASC'
        );
        $stmt->execute(['year' => $selectedYear]);
        $cars = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cars by Race Year</title>
</head>
<body>
    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <label for="year">Race year:</label>
        <select id="year" name="year">
            <?php foreach ($years as $year): ?>
                <option value="<?= htmlspecialchars((string) $year) ?>"
                    <?= (string) $year === (string) $selectedYear ? 'selected' : '' ?>>
                    <?= htmlspecialchars((string) $year) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Show Cars</button>
    </form>

    <?php if ($selectedYear !== ''): ?>
        <h2>Cars in <?= htmlspecialchars((string) $selectedYear) ?></h2>
        <table border="1" cellpadding="6">
            <tr>
                <th>Car Model</th>
                <th>Driver</th>
                <th>Place</th>
            </tr>
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= htmlspecialchars($car['CarModel']) ?></td>
                    <td><?= htmlspecialchars($car['Driver']) ?></td>
                    <td><?= htmlspecialchars((string) $car['Place']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
