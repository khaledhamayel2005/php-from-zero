<?php
// Database example
$dbhost = "localhost";
$dbusername = "httpd";
$dbuserpassword = "web";
$default_dbname = "webTest";
$records_per_page = 2;
$user_tablename = "user";

function html_header()
{
    ?>


    <html>

    <head>
        <title>User Record Viewer</title>
    </head>

    <body>
        <?php

}

function html_footer()
{
    ?>


    </body>

    </html>
    <?php

}

function db_connect($dbname = "webTest", $username = "httpd", $password = "web")
{
    global $dbhost;

    /*
     * Create the pdo object
     * host: is the host name
     * dbname: database name
     */
    // Try block
    try {
        // Connect DB
        $pdo = new PDO(
            "mysql:host=$dbhost;dbname=$dbname",
            $username,
            $password,
        );

        return $pdo;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function error_message($msg)
{
    // Page layout
    html_header();
    echo "<p><em> error $msg</em></p>";
    // Page layout
    html_footer();
    // Stop script
    exit();
}
function enum_options()
{
    return ["Customer", "Manager", "Programmer"];
}

?>