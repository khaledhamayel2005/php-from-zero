<?php
// Minimal registration page using mysqli
// This file is intentionally simple so you can study it.
// Inline comments explain each step in English.

// Show PHP runtime errors in browser to help debugging while studying.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load DB credentials from `config.php` (keeps credentials separate)
require_once __DIR__ . '/config.php';

// Start session to support redirects or storing messages (kept minimal)
if (session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$success = '';

// Handle form submission when method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

  // Basic validation (server-side). Keep it short for clarity.
  if ($fname === '' || $lname === '') $errors[] = 'First and last name are required.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
  if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

    if (empty($errors)) {
    // Disable mysqli exceptions so errors are returned in $conn->error instead of throwing
      mysqli_report(MYSQLI_REPORT_OFF);
      // Connect to database using credentials from config
      $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
      if ($conn->connect_error) {
        // Connection failed — helpful message for learners
        $errors[] = 'Database connection failed: ' . $conn->connect_error;
      } else {
        // Create a simple `users` table if it does not exist. This keeps setup zero-config.
        $create = "CREATE TABLE IF NOT EXISTS users (
          id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
          fname VARCHAR(100) NOT NULL,
          lname VARCHAR(100) NOT NULL,
          email VARCHAR(255) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        if (!$conn->query($create)) {
          $errors[] = 'Failed creating users table: ' . $conn->error;
        } else {
          // Ensure password column can hold modern password_hash output
          $alter = "ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL";
          if (!$conn->query($alter)) {
            // Not fatal: some MySQL versions will return error if column already matches.
            $errors[] = 'Warning: could not adjust password column size: ' . $conn->error;
          }

          // Protect values from SQL injection by escaping before interpolation
          $emailEsc = $conn->real_escape_string($email);
          // Check if email already exists
          $check = $conn->query("SELECT id FROM users WHERE email = '$emailEsc' LIMIT 1");
          if ($check === false) {
            $errors[] = 'Query error: ' . $conn->error;
          } elseif ($check->num_rows > 0) {
            $errors[] = 'Email is already registered.';
          } else {
            // Hash the password using PHP's recommended algorithm
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $fnameEsc = $conn->real_escape_string($fname);
            $lnameEsc = $conn->real_escape_string($lname);
            // Insert user record
            $sql = "INSERT INTO users (fname, lname, email, password) VALUES ('$fnameEsc', '$lnameEsc', '$emailEsc', '$hash')";
            if ($conn->query($sql)) {
              $success = 'Registered successfully. You can <a href="simple_login.php">login</a>.';
            } else {
              $errors[] = 'Insert failed: ' . $conn->error;
            }
          }
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
  <main style="max-width:420px;margin:48px auto;padding:18px;background:#fff;border-radius:8px">
    <h2>Register</h2>
    <?php if ($success): ?><div style="background:#ecfdf5;padding:10px;border-left:4px solid #10b981"><?php echo $success; ?></div><?php endif; ?>
    <?php if (!empty($errors)): ?><div style="background:#fff7ed;padding:10px;border-left:4px solid #f59e0b"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div><?php endif; ?>
    <form method="post" action="register.php">
      <label>First name</label><br>
      <input name="fname" required><br><br>
      <label>Last name</label><br>
      <input name="lname" required><br><br>
      <label>Email</label><br>
      <input name="email" type="email" required><br><br>
      <label>Password</label><br>
      <input name="password" type="password" required><br><br>
      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="simple_login.php">Login</a></p>
  </main>
</body>
</html>
