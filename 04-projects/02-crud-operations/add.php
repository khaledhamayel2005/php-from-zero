<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$errors = [];
$success = '';
$values = [
    'fname' => '',
    'lname' => '',
    'email' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['fname'] = trim($_POST['fname'] ?? '');
    $values['lname'] = trim($_POST['lname'] ?? '');
    $values['email'] = trim($_POST['email'] ?? '');
    $userPassword = $_POST['password'] ?? '';

    if ($values['fname'] === '') {
        $errors[] = 'First name is required.';
    }

    if ($values['lname'] === '') {
        $errors[] = 'Last name is required.';
    }

    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }

    if (strlen($userPassword) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if (empty($errors)) {
        $connection = dbConnection();

        $check = $connection->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $check->bind_param('s', $values['email']);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Email already exists.';
        } else {
            $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

            $insert = $connection->prepare('INSERT INTO users (fname, lname, email, password) VALUES (?, ?, ?, ?)');
            $insert->bind_param('ssss', $values['fname'], $values['lname'], $values['email'], $hashedPassword);

            if ($insert->execute()) {
                header('Location: index.php');
                exit;
            }

            $errors[] = 'Insert failed: ' . $connection->error;
        }

        $connection->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="page form-page">
        <div class="header-row">
            <div>
                <h1>Add User</h1>
                <p class="subtitle">Insert a new row into <strong>users</strong>.</p>
            </div>
            <a class="button secondary" href="index.php">Back</a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" class="card-form">
            <label>
                First Name
                <input type="text" name="fname" value="<?php echo htmlspecialchars($values['fname']); ?>" required>
            </label>

            <label>
                Last Name
                <input type="text" name="lname" value="<?php echo htmlspecialchars($values['lname']); ?>" required>
            </label>

            <label>
                Email
                <input type="email" name="email" value="<?php echo htmlspecialchars($values['email']); ?>" required>
            </label>

            <label>
                Password
                <input type="password" name="password" required>
            </label>

            <button type="submit" class="button">Save User</button>
        </form>
    </main>
</body>
</html>
