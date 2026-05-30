<?php
require_once 'config.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($fname === '' || $lname === '') {
        $errors[] = 'First and last name are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if (empty($errors)) {

        mysqli_report(MYSQLI_REPORT_OFF);

        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        if ($conn->connect_error) {
            $errors[] = 'Database connection failed: ' . $conn->connect_error;
        } else {

            $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");

            if (!$checkStmt) {
                $errors[] = 'Prepare failed: ' . $conn->error;
            } else {

                $checkStmt->bind_param("s", $email);
                $checkStmt->execute();

                $result = $checkStmt->get_result();

                if ($result->num_rows > 0) {
                    $errors[] = 'Email is already registered.';
                } else {

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $insertStmt = $conn->prepare(
                        "INSERT INTO users (fname, lname, email, password) VALUES (?, ?, ?, ?)"
                    );

                    if (!$insertStmt) {
                        $errors[] = 'Prepare failed: ' . $conn->error;
                    } else {

                        $insertStmt->bind_param("ssss", $fname, $lname, $email, $hashedPassword);

                        if ($insertStmt->execute()) {
                            $success = 'Registered successfully. You can <a href="simple_login.php">login</a>.';
                        } else {
                            $errors[] = 'Insert failed: ' . $insertStmt->error;
                        }

                        $insertStmt->close();
                    }
                }

                $checkStmt->close();
            }

            $conn->close();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="page form-page">

    <h2>Register</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php" class="card-form">

        <label>
            First name
            <input name="fname" value="<?php echo htmlspecialchars($_POST['fname'] ?? ''); ?>" required>
        </label>

        <label>
            Last name
            <input name="lname" value="<?php echo htmlspecialchars($_POST['lname'] ?? ''); ?>" required>
        </label>

        <label>
            Email
            <input name="email" type="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
        </label>

        <label>
            Password
            <input name="password" type="password" required>
        </label>

        <button type="submit">Register</button>

    </form>

    <p>Already have an account? <a class="text-link" href="simple_login.php">Login</a></p>

</main>

</body>
</html>
