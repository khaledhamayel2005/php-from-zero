<html>
    <head>
    </head>
    <body>
<?php
// Database example
// Load file
require_once "config.inc.php";
include_once "Item.php";
$pdo = db_connect();
// get everything from catalog table
$query = "SELECT * FROM catalog ORDER BY Name ";

/* Create a PDOStatement object */
// Run query
$result = $pdo->query($query);
?>
    <table border=\"0\">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
<?php
while ($item = $result->fetchObject("Item")) {
    echo $item->outputAsRow();
}
echo "</tbody>";
echo "</table>";
$pdo = null;
?>
</body>
</html>