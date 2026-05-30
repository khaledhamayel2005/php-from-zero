<?php
// Database example
define("DBHOST", "localhost");
define("DBNAME", "webTest");
define("DBUSER", "httpd");
define("DBPASS", "web");
function db_connect(
    $dbhost = DBHOST,
    $dbname = DBNAME,
    $username = DBUSER,
    $password = DBPASS,
) {
    // Try block
    try {
        /*
         * Create the pdo object
         * host: is the host name
         * dbname: database name
         */

        // Connect DB
        $pdo = new PDO(
            "mysql:host=$dbhost;dbname=$dbname",
            $username,
            $password,
        );

        return $pdo;
    } catch (PDOException $e) {
        // Stop script
        die($e->getMessage());
    }
}
?>
