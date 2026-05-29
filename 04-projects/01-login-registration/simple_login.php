<?php
// Minimal login page using mysqli
// This file is kept tiny and well-commented for learning.

// Load DB credentials from `config.php` and start session
require_once __DIR__ . '/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$welcome = '';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset(); session_destroy(); header('Location: simple_login.php'); exit;
}

// When the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') $errors[] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email.';
    if ($password === '') $errors[] = 'Password is required.';

    if (empty($errors)) {
      // Connect to DB and attempt to fetch the user record
      $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
      if ($conn->connect_error) {
        $errors[] = 'DB connection failed.';
      } else {
        // Escape email to avoid injection in the query string
        $emailEsc = $conn->real_escape_string($email);
        $res = $conn->query("SELECT id,fname,lname,password FROM users WHERE email='$emailEsc' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
          // Verify the entered password against the stored hash
          if (password_verify($password, $row['password'])) {
            // Successful login: store minimal user info in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = trim($row['fname'].' '.$row['lname']);
            $welcome = 'Welcome, '.htmlspecialchars($_SESSION['user_name']).'!';
          } else {
            $errors[] = 'Invalid email or password.';
          }
        } else {
          // No matching user found
          $errors[] = 'Invalid email or password.';
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
  <style> .box{max-width:420px;margin:48px auto;padding:18px;background:#fff;border-radius:8px} .note{background:#fff7ed;padding:10px;border-left:4px solid #f59e0b} .success{background:#ecfdf5;padding:10px;border-left:4px solid #10b981} </style>
</head>
<body>
  <main class="box">
    <?php if (!empty($welcome) || !empty($_SESSION['user_name'])): ?>
      <div class="success"><?php echo $welcome ?: 'Welcome, '.htmlspecialchars($_SESSION['user_name']).'!'; ?></div>
      <p><a href="?action=logout">Logout</a></p>
    <?php else: ?>
      <h2>Login</h2>
      <?php if (!empty($errors)): ?><div class="note"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div><?php endif; ?>
      <form method="post" action="simple_login.php">
        <label>Email</label><br>
        <input name="email" type="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required><br><br>
        <label>Password</label><br>
        <input name="password" type="password" required><br><br>
        <button type="submit">Login</button>
      </form>
      <p><a href="register.php">Register</a></p>
    <?php endif; ?>
  </main>
</body>
</html>
