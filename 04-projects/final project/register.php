<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/functions.php';

if (currentUser() !== null) {
    redirect('index.php');
}

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '') {
        $errors[] = 'Name is required.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if ($errors === []) {
        try {
            $stmt = db()->prepare(
                'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)'
            );
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            $_SESSION['user_id'] = (int) db()->lastInsertId();
            redirect('index.php');
        } catch (PDOException $e) {
            $errors[] = 'This email is already used.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Final Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="auth-page">
    <section class="panel">
        <h1>Register</h1>
        <p class="muted">Create a user, then manage your personal tasks.</p>

        <?php if ($errors !== []): ?>
            <div class="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?= e($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label>
                Name
                <input type="text" name="name" value="<?= e($name) ?>" required>
            </label>

            <label>
                Email
                <input type="email" name="email" value="<?= e($email) ?>" required>
            </label>

            <label>
                Password
                <input type="password" name="password" minlength="6" required>
            </label>

            <button type="submit">Create account</button>
        </form>

        <p class="switch">Already have an account? <a href="login.php">Login</a></p>
    </section>
</main>
</body>
</html>
