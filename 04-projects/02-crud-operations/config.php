<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (empty($_SESSION['user_id'])) {
	header('Location: ../01-login-registration/simple_login.php');
	exit;
}

function dbConnection(): mysqli
{
	mysqli_report(MYSQLI_REPORT_OFF);

	$connection = new mysqli('localhost', 'root', '', 'test');

	if ($connection->connect_error) {
		die('Database connection failed: ' . $connection->connect_error);
	}

	$connection->set_charset('utf8mb4');
	return $connection;
}
