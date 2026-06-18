<?php
$name = "";
$mark = "";
$errors = array();
$grade = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $mark = trim($_POST["mark"] ?? "");

    if ($name == "") {
        $errors[] = "Student name is required.";
    }

    if ($mark == "" || !is_numeric($mark)) {
        $errors[] = "Mark must be a number.";
    } elseif ($mark < 0 || $mark > 100) {
        $errors[] = "Mark must be between 0 and 100.";
    }

    if (empty($errors)) {
        if ($mark >= 90) {
            $grade = "A";
        } elseif ($mark >= 80) {
            $grade = "B";
        } elseif ($mark >= 70) {
            $grade = "C";
        } elseif ($mark >= 60) {
            $grade = "D";
        } else {
            $grade = "Fail";
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Student Grade</title>
  </head>
  <body>
    <h1>Student Grade</h1>

    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
      <h2>Result</h2>
      <p>Name: <?php echo htmlspecialchars($name); ?></p>
      <p>Mark: <?php echo htmlspecialchars($mark); ?></p>
      <p>Grade: <?php echo $grade; ?></p>
    <?php endif; ?>

    <form method="post" action="solution.php">
      <p>
        <label>Student name:
          <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        </label>
      </p>
      <p>
        <label>Mark:
          <input type="text" name="mark" value="<?php echo htmlspecialchars($mark); ?>">
        </label>
      </p>
      <p><button type="submit">Calculate</button></p>
    </form>
  </body>
</html>

