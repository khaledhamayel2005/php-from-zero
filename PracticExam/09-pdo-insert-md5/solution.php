<?php
require_once "config.inc.php";

$errors = array();
$message = "";
$users = array();
$userid = "";
$fullname = "";
$role = "Student";

try {
    $pdo = db_connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userid = trim($_POST["userid"] ?? "");
        $password = $_POST["password"] ?? "";
        $fullname = trim($_POST["fullname"] ?? "");
        $role = $_POST["role"] ?? "Student";

        if ($userid == "") {
            $errors[] = "User ID is required.";
        }
        if ($password == "") {
            $errors[] = "Password is required.";
        }
        if ($fullname == "") {
            $errors[] = "Full name is required.";
        }

        if (empty($errors)) {
            $check = $pdo->prepare("SELECT COUNT(*) FROM practice_users WHERE userid = ?");
            $check->bindValue(1, $userid);
            $check->execute();

            if ($check->fetchColumn() > 0) {
                $errors[] = "User ID already exists.";
            }
        }

        if (empty($errors)) {
            $sql = "INSERT INTO practice_users (userid, userpassword, fullname, role)
                    VALUES (?, md5(?), ?, ?)";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $userid);
            $statement->bindValue(2, $password);
            $statement->bindValue(3, $fullname);
            $statement->bindValue(4, $role);
            $statement->execute();
            $message = "User registered.";
            $userid = "";
            $fullname = "";
            $role = "Student";
        }
    }

    $result = $pdo->query("SELECT usernumber, userid, fullname, role FROM practice_users ORDER BY usernumber");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
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
    <title>User Registration</title>
  </head>
  <body>
    <h1>User Registration</h1>

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

    <form method="post" action="solution.php">
      <p>
        <label>User ID:
          <input type="text" name="userid" value="<?php echo htmlspecialchars($userid); ?>">
        </label>
      </p>
      <p>
        <label>Password:
          <input type="password" name="password">
        </label>
      </p>
      <p>
        <label>Full name:
          <input type="text" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
        </label>
      </p>
      <p>
        <label>Role:
          <select name="role">
            <option value="Student" <?php if ($role == "Student") echo "selected"; ?>>Student</option>
            <option value="Manager" <?php if ($role == "Manager") echo "selected"; ?>>Manager</option>
            <option value="Programmer" <?php if ($role == "Programmer") echo "selected"; ?>>Programmer</option>
          </select>
        </label>
      </p>
      <p><button type="submit">Register</button></p>
    </form>

    <h2>Users</h2>
    <table border="1" cellpadding="6">
      <tr>
        <th>No.</th>
        <th>User ID</th>
        <th>Full Name</th>
        <th>Role</th>
      </tr>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?php echo $user["usernumber"]; ?></td>
          <td><?php echo htmlspecialchars($user["userid"]); ?></td>
          <td><?php echo htmlspecialchars($user["fullname"]); ?></td>
          <td><?php echo htmlspecialchars($user["role"]); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </body>
</html>

