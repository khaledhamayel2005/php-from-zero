<?php
session_start();

try {
    $dsn = "mysql:host=localhost;dbname=race;charset=utf8mb4";
    $user = "test";
    $password = "test";

    $pdo = new PDO($dsn, $user, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$cars = [];

// If the user submitted the form
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["year"])) {

    // Store selected year in session
    $_SESSION["year"] = $_POST["year"];

    $sql = "SELECT carmodel, driver, place
            FROM collection
            WHERE raceyear = :year
            ORDER BY place ASC";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":year" => $_SESSION["year"]
    ]);

    $cars = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Race Cars</title>
</head>
<body>

<form method="post">
    <label>Select Race Year:</label>

    <select name="year">
        <option value="2001">2001</option>
        <option value="2002">2002</option>
    </select>

    <input type="submit" value="Show Cars">
</form>

<br>

<?php if (!empty($cars)): ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Car Model</th>
            <th>Driver</th>
            <th>Place</th>
        </tr>

        <?php foreach ($cars as $car): ?>
            <tr>
                <td><?php echo htmlspecialchars($car["carmodel"]); ?></td>
                <td><?php echo htmlspecialchars($car["driver"]); ?></td>
                <td><?php echo htmlspecialchars($car["place"]); ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php endif; ?>

</body>
</html>