<?php
define('DBHOST', 'localhost');
define('DBNAME', 'web1231439_souvenirStore');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBCONNSTRING', 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8mb4');

try {
    // Connect to MySQL database.
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
