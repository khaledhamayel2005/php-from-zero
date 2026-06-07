<?php

try {
    // Database connection information
    $dsn = "mysql:host=localhost;dbname=school;charset=utf8mb4";
    $user = "test";
    $password = "test";

    // Create PDO connection
    $pdo = new PDO($dsn, $user, $password);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// This array will store the students to be displayed
$students = [];

// If the user clicked Filter and sent GPA
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["gpa"])) {

    $gpa = $_POST["gpa"];

    // Select students whose GPA is greater than the entered value
    $sql = "SELECT studentid, name, gpa 
            FROM student 
            WHERE gpa > :gpa";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":gpa" => $gpa
    ]);

    $students = $stmt->fetchAll();

} else {

    // If GPA was not sent, display all students
    $sql = "SELECT studentid, name, gpa 
            FROM student";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $students = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students GPA Filter</title>
</head>
<body>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Student id</th>
                <th>Name</th>
                <th>GPA</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student["studentid"]); ?></td>
                    <td><?php echo htmlspecialchars($student["name"]); ?></td>
                    <td><?php echo htmlspecialchars($student["gpa"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <form method="post">
        <label>GPA greater than:</label>
        <input type="text" name="gpa">

        <br><br>

        <input type="submit" value="Filter">
    </form>

</body>
</html>