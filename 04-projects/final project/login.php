<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/functions.php';

if (currentUser() !== null) {
    redirect('index.php');
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberName = isset($_POST['remember_name']);

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if ($errors === []) {
        $stmt = db()->prepare('SELECT id, name, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];

            if ($rememberName) {
                setcookie('visitor_name', $user['name'], time() + 60 * 60 * 24 * 7);
            }

            redirect('index.php');
        }

        $errors[] = 'Wrong email or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Final Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="auth-page">
    <section class="panel">
        <h1>Login</h1>
        <p class="muted">Practice sessions, cookies, forms, and PDO in one place.</p>

        <?php if ($errors !== []): ?>
            <div class="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?= e($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label>
                Email
                <input type="email" name="email" value="<?= e($email) ?>" required>
            </label>

            <label>
                Password
                <input type="password" name="password" required>
            </label>

            <label class="check-row">
                <input type="checkbox" name="remember_name">
                Remember my name
            </label>

            <button type="submit">Login</button>
        </form>

        <p class="switch">No account? <a href="register.php">Register</a></p>
    </section>
</main>
</body>
</html>
