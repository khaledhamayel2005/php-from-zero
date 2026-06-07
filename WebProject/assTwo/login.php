<?php
session_start();
require_once('dbconfig.inc.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get login data from form.
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === '' || $password === '') {
        $error = 'Email and password are required.';
    } else {
        // Find user by email.
        $sql = 'SELECT user_id, user_code, first_name, last_name, email, password, role
                FROM users
                WHERE email = :email
                AND password = md5(:password)';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            ':email' => $email,
            ':password' => $password
        ));
        $user = $statement->fetch();

        if ($user) {
            // Save login data in session.
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_code'] = $user['user_code'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['role'];

            if (isset($_SESSION['return_to']) && $_SESSION['return_to'] !== '') {
                $returnTo = $_SESSION['return_to'];
                unset($_SESSION['return_to']);
                header('Location: ' . $returnTo);
                exit;
            }

            header('Location: products.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
    <section>
        <h2>Login</h2>
        <?php if ($error !== '') { ?>
            <p><?php echo h($error); ?></p>
        <?php } ?>
        <form method="post" action="login.php">
            <fieldset>
                <legend>Account Login</legend>
                <p><label>Email <input type="email" name="email" value="<?php echo h($email); ?>"></label></p>
                <p><label>Password <input type="password" name="password"></label></p>
            </fieldset>
            <p><input type="submit" value="Login"></p>
        </form>
    </section>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
