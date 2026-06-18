<?php
    session_start();
    require_once  'config.php';

    $error = '';
    $email = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $error = 'Email and password are required.';
        } else {
            $sql = "SELECT * FROM users WHERE email = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && $user['password'] === $password) {
                $_SESSION['fname'] = $user['fname'] ?? '';
                $_SESSION['lname'] = $user['lname'] ?? '';
                $_SESSION['email'] = $email;
                $_SESSION['logged'] = true;

                header("Location: welcome.php");
                exit;
            }

            $error = 'Invalid email or password.';
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if ($error !== ''): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" action="index.php">
        <fieldset>
            <legend>Log in </legend>
            <label for="email">Enter Your Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required> <br>


            <label for="password">Enter Your Password</label>
            <input type="password" name="password" id="password" required> <br>


            <input type="submit" name="submit">
            <a href="register.php">register</a>
        </fieldset>
    </form>

</body>
</html>