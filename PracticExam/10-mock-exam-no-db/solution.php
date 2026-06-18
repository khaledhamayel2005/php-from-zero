<?php
session_start();

$courses = array(
    "c1" => array("code" => "COMP231", "title" => "Web Programming", "credits" => 3, "fee" => 120),
    "c2" => array("code" => "COMP232", "title" => "Web Lab", "credits" => 1, "fee" => 60),
    "c3" => array("code" => "COMP240", "title" => "Database", "credits" => 3, "fee" => 130),
    "c4" => array("code" => "COMP241", "title" => "Database Lab", "credits" => 1, "fee" => 70),
);

if (!isset($_SESSION["history"])) {
    $_SESSION["history"] = array();
}

if (isset($_GET["clear"])) {
    $_SESSION["history"] = array();
    header("Location: solution.php");
    exit();
}

$student = "";
$level = "regular";
$selected = array();
$errors = array();
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student = trim($_POST["student"] ?? "");
    $level = $_POST["level"] ?? "regular";
    $selected = $_POST["courses"] ?? array();

    if ($student == "") {
        $errors[] = "Student name is required.";
    }

    if (empty($selected)) {
        $errors[] = "Select at least one course.";
    }

    if (empty($errors)) {
        $totalCredits = 0;
        $totalFees = 0;
        $titles = array();

        foreach ($selected as $courseId) {
            if (isset($courses[$courseId])) {
                $totalCredits += $courses[$courseId]["credits"];
                $totalFees += $courses[$courseId]["fee"];
                $titles[] = $courses[$courseId]["code"];
            }
        }

        $discount = 0;
        if ($level == "employee") {
            $discount = $totalFees * 0.20;
        }

        $finalTotal = $totalFees - $discount;

        $result = array(
            "student" => $student,
            "level" => $level,
            "courses" => implode(", ", $titles),
            "credits" => $totalCredits,
            "fees" => $totalFees,
            "discount" => $discount,
            "final" => $finalTotal,
        );

        $_SESSION["history"][] = $result;
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Course Registration</title>
  </head>
  <body>
    <h1>Course Registration</h1>

    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form method="post" action="solution.php">
      <p>
        <label>Student name:
          <input type="text" name="student" value="<?php echo htmlspecialchars($student); ?>">
        </label>
      </p>

      <fieldset>
        <legend>Level</legend>
        <label>
          <input type="radio" name="level" value="regular" <?php if ($level == "regular") echo "checked"; ?>>
          Regular
        </label>
        <label>
          <input type="radio" name="level" value="employee" <?php if ($level == "employee") echo "checked"; ?>>
          Employee
        </label>
      </fieldset>

      <fieldset>
        <legend>Courses</legend>
        <?php foreach ($courses as $id => $course): ?>
          <label>
            <input type="checkbox" name="courses[]" value="<?php echo htmlspecialchars($id); ?>" <?php if (in_array($id, $selected)) echo "checked"; ?>>
            <?php echo htmlspecialchars($course["code"] . " - " . $course["title"] . " ($" . $course["fee"] . ")"); ?>
          </label>
          <br>
        <?php endforeach; ?>
      </fieldset>

      <p><button type="submit">Register</button></p>
    </form>

    <?php if ($result != null): ?>
      <h2>Last Result</h2>
      <p>Student: <?php echo htmlspecialchars($result["student"]); ?></p>
      <p>Courses: <?php echo htmlspecialchars($result["courses"]); ?></p>
      <p>Total credits: <?php echo $result["credits"]; ?></p>
      <p>Total fees: <?php echo $result["fees"]; ?></p>
      <p>Discount: <?php echo $result["discount"]; ?></p>
      <p>Final total: <?php echo $result["final"]; ?></p>
    <?php endif; ?>

    <h2>History</h2>
    <table border="1" cellpadding="6">
      <tr>
        <th>Student</th>
        <th>Level</th>
        <th>Courses</th>
        <th>Credits</th>
        <th>Final Total</th>
      </tr>
      <?php foreach ($_SESSION["history"] as $item): ?>
        <tr>
          <td><?php echo htmlspecialchars($item["student"]); ?></td>
          <td><?php echo htmlspecialchars($item["level"]); ?></td>
          <td><?php echo htmlspecialchars($item["courses"]); ?></td>
          <td><?php echo $item["credits"]; ?></td>
          <td><?php echo $item["final"]; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <p><a href="solution.php?clear=1">Clear history</a></p>
  </body>
</html>

