<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
	header('Location: index.php');
	exit;
}

try {
	$connection = dbConnection();
	$delete = $connection->prepare('DELETE FROM users WHERE id = ?');
	$delete->bind_param('i', $id);
	$delete->execute();
	$delete->close();
	$connection->close();
} catch (Throwable $throwable) {
	die('Delete failed: ' . htmlspecialchars($throwable->getMessage()));
}

header('Location: index.php');
exit;
