<?php
session_start();
require_once "config.inc.php";

$errors = array();
$message = "";
$courses = array();
$registrations = array();

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: solution.php");
    exit();
}

try {
    $pdo = db_connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $userid = trim($_POST["userid"] ?? "");
        $password = $_POST["password"] ?? "";

        $sql = "SELECT userid, fullname, role
                FROM practice_members
                WHERE userid = ? AND userpassword = md5(?)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $userid);
        $statement->bindValue(2, $password);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["userid"] = $user["userid"];
            $_SESSION["fullname"] = $user["fullname"];
            header("Location: solution.php");
            exit();
        } else {
            $errors[] = "Invalid user id or password.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"]) && isset($_SESSION["userid"])) {
        $courseId = $_POST["course_id"] ?? "";

        $check = $pdo->prepare("SELECT COUNT(*) FROM practice_registrations WHERE userid = ? AND course_id = ?");
        $check->bindValue(1, $_SESSION["userid"]);
        $check->bindValue(2, $courseId);
        $check->execute();

        if ($check->fetchColumn() > 0) {
            $errors[] = "You are already registered in this course.";
        } else {
            $insert = $pdo->prepare("INSERT INTO practice_registrations (userid, course_id) VALUES (?, ?)");
            $insert->bindValue(1, $_SESSION["userid"]);
            $insert->bindValue(2, $courseId);
            $insert->execute();
            $message = "Course registered.";
        }
    }

    $result = $pdo->query("SELECT course_id, code, title, credits FROM practice_courses ORDER BY code");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $courses[] = $row;
    }

    if (isset($_SESSION["userid"])) {
        $sql = "SELECT r.id, c.code, c.title, c.credits, r.registered_at
                FROM practice_registrations r
                JOIN practice_courses c ON r.course_id = c.course_id
                WHERE r.userid = ?
                ORDER BY r.id DESC";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $_SESSION["userid"]);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $registrations[] = $row;
        }
    }

    $pdo = null;
} catch (PDOException $e) {
    $errors[] = $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PDO Mock Exam</title>
  </head>
  <body>
    <h1>PDO Mock Exam</h1>

    <?php if ($message != ""): ?>
      <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if (!isset($_SESSION["userid"])): ?>
      <form method="post" action="solution.php">
        <p>
          <label>User ID:
            <input type="text" name="userid">
          </label>
        </p>
        <p>
          <label>Password:
            <input type="password" name="password">
          </label>
        </p>
        <p><button type="submit" name="login">Login</button></p>
      </form>
      <p>Try student / 1234</p>
    <?php else: ?>
      <p>
        Welcome <?php echo htmlspecialchars($_SESSION["fullname"]); ?>
        | <a href="solution.php?logout=1">Logout</a>
      </p>

      <h2>Register Course</h2>
      <form method="post" action="solution.php">
        <p>
          <label>Course:
            <select name="course_id">
              <?php foreach ($courses as $course): ?>
                <option value="<?php echo $course["course_id"]; ?>">
                  <?php echo htmlspecialchars($course["code"] . " - " . $course["title"]); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </label>
        </p>
        <p><button type="submit" name="register">Register</button></p>
      </form>

      <h2>My Registrations</h2>
      <table border="1" cellpadding="6">
        <tr>
          <th>Code</th>
          <th>Title</th>
          <th>Credits</th>
          <th>Date</th>
        </tr>
        <?php foreach ($registrations as $reg): ?>
          <tr>
            <td><?php echo htmlspecialchars($reg["code"]); ?></td>
            <td><?php echo htmlspecialchars($reg["title"]); ?></td>
            <td><?php echo $reg["credits"]; ?></td>
            <td><?php echo htmlspecialchars($reg["registered_at"]); ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </body>
</html>

