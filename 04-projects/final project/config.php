<?php
declare(strict_types=1);

define('DB_HOST', 'localhost');
define('DB_NAME', 'final_project');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4');

function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    return $pdo;
}
