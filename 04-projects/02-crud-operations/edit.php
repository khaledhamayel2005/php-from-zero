<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$errors = [];
$record = [
    'id' => 0,
    'fname' => '',
    'lname' => '',
    'email' => '',
];

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    $connection = dbConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $record['fname'] = trim($_POST['fname'] ?? '');
        $record['lname'] = trim($_POST['lname'] ?? '');
        $record['email'] = trim($_POST['email'] ?? '');
        $userPassword = $_POST['password'] ?? '';

        if ($record['fname'] === '') {
            $errors[] = 'First name is required.';
        }

        if ($record['lname'] === '') {
            $errors[] = 'Last name is required.';
        }

        if (!filter_var($record['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required.';
        }

        if (empty($errors)) {
            $check = $connection->prepare('SELECT id FROM users WHERE email = ? AND id <> ? LIMIT 1');
            if (!$check) {
                throw new RuntimeException('Prepare failed: ' . $connection->error);
            }

            $check->bind_param('si', $record['email'], $id);
            $check->execute();
            $existing = $check->get_result();

            if ($existing && $existing->num_rows > 0) {
                $errors[] = 'Email already exists.';
            } else {
                if ($userPassword !== '') {
                    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
                    $update = $connection->prepare('UPDATE users SET fname = ?, lname = ?, email = ?, password = ? WHERE id = ?');
                    if (!$update) {
                        throw new RuntimeException('Prepare failed: ' . $connection->error);
                    }

                    $update->bind_param('ssssi', $record['fname'], $record['lname'], $record['email'], $hashedPassword, $id);
                } else {
                    $update = $connection->prepare('UPDATE users SET fname = ?, lname = ?, email = ? WHERE id = ?');
                    if (!$update) {
                        throw new RuntimeException('Prepare failed: ' . $connection->error);
                    }

                    $update->bind_param('sssi', $record['fname'], $record['lname'], $record['email'], $id);
                }

                if ($update->execute()) {
                    header('Location: index.php');
                    exit;
                }

                $errors[] = 'Update failed: ' . $connection->error;
            }

            $check->close();
        }
    }

    $query = $connection->prepare('SELECT id, fname, lname, email FROM users WHERE id = ? LIMIT 1');
    if (!$query) {
        throw new RuntimeException('Prepare failed: ' . $connection->error);
    }

    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows === 1) {
        $record = $result->fetch_assoc();
    } else {
        header('Location: index.php');
        exit;
    }

    $query->close();
    $connection->close();
} catch (Throwable $throwable) {
    $errors[] = $throwable->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="page form-page">
        <div class="header-row">
            <div>
                <h1>Edit User</h1>
                <p class="subtitle">Update an existing row in <strong>users</strong>.</p>
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
                <input type="text" name="fname" value="<?php echo htmlspecialchars($record['fname']); ?>" required>
            </label>

            <label>
                Last Name
                <input type="text" name="lname" value="<?php echo htmlspecialchars($record['lname']); ?>" required>
            </label>

            <label>
                Email
                <input type="email" name="email" value="<?php echo htmlspecialchars($record['email']); ?>" required>
            </label>

            <label>
                New Password
                <input type="password" name="password" placeholder="Leave blank to keep current password">
            </label>

            <button type="submit" class="button">Update User</button>
        </form>
    </main>
</body>
</html>
