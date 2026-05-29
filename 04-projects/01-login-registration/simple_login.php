<?php
require_once 'config.php';

session_start();

$errors = [];
$welcome = '';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();

    header('Location: simple_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {

        mysqli_report(MYSQLI_REPORT_OFF);

        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        if ($conn->connect_error) {
            $errors[] = 'Database connection failed: ' . $conn->connect_error;
        } else {

            $stmt = $conn->prepare(
                "SELECT id, fname, lname, password FROM users WHERE email = ? LIMIT 1"
            );

            if (!$stmt) {
                $errors[] = 'Prepare failed: ' . $conn->error;
            } else {

                $stmt->bind_param("s", $email);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows === 1) {

                    $user = $result->fetch_assoc();

                    if (password_verify($password, $user['password'])) {

                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = trim($user['fname'] . ' ' . $user['lname']);

                        $welcome = 'Welcome, ' . htmlspecialchars($_SESSION['user_name']) . '!';

                    } else {
                        $errors[] = 'Invalid email or password.';
                    }

                } else {
                    $errors[] = 'Invalid email or password.';
                }

                $stmt->close();
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
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .box {
            max-width: 420px;
            margin: 48px auto;
            padding: 18px;
            background: #fff;
            border-radius: 8px;
        }

        .note {
            background: #fff7ed;
            padding: 10px;
            border-left: 4px solid #f59e0b;
        }

        .success {
            background: #ecfdf5;
            padding: 10px;
            border-left: 4px solid #10b981;
        }
    </style>
</head>

<body>

<main class="box">

    <?php if (!empty($welcome) || !empty($_SESSION['user_name'])): ?>

        <div class="success">
            <?php
                echo $welcome ?: 'Welcome, ' . htmlspecialchars($_SESSION['user_name']) . '!';
            ?>
        </div>

        <p>
            <a href="?action=logout">Logout</a>
        </p>

    <?php else: ?>

        <h2>Login</h2>

        <?php if (!empty($errors)): ?>
            <div class="note">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo htmlspecialchars($e); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="simple_login.php">

            <label>Email</label><br>
            <input 
                name="email" 
                type="email" 
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                required
            >
            <br><br>

            <label>Password</label><br>
            <input name="password" type="password" required>
            <br><br>

            <button type="submit">Login</button>

        </form>

        <p>
            <a href="register.php">Register</a>
        </p>

    <?php endif; ?>

</main>

</body>
</html>