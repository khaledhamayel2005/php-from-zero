<?php
define("DBHOST", "localhost");
define("DBNAME", "webTest");
define("DBUSER", "httpd");
define("DBPASS", "web");

function db_connect()
{
    try {
        $pdo = new PDO(
            "mysql:host=" . DBHOST . ";dbname=" . DBNAME,
            DBUSER,
            DBPASS
        );
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>

