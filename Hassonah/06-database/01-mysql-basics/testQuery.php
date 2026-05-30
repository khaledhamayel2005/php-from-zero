<html>
    <head>
    </head>
<body>
<?php
// Database example
/*
 * host: is the host name
 * dbname: database name
 localhost
 */
define("DBNAME", "webTest");
$connectionString = "mysql:host=127.0.0.1;dbname=" . DBNAME;
$user = "httpd";
$password = "web";

// Try block
try {
    /*
     * Create the pdo object
     */
    // Connect DB
    $pdo = new PDO($connectionString, $user, $password);

    // get everything from catalog table
    $query = "SELECT Name, Price " . "FROM catalog " . "ORDER BY Name ";

    /* Create a PDOStatement object */
    // Run query
    $dbResults = $pdo->query($query);

    // Fetch data
    $rows = $dbResults->fetchAll();
} catch (PDOException $e) {
    // Stop script
    die($e->getMessage());
}
?>
<table border=\"0\">
    <thead>
    <tr>
        <th>Item</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>

        <?php
        foreach ($rows as $row): ?>
        <tr>
                                                <td><?php echo $row["Name"]; ?></td>
            <td><?php echo $row["Price"]; ?></td>
        </tr>
        <?php

            endforeach;
        $pdo = null;
        ?>

    </tbody>
</table>
</body>
</htm>
