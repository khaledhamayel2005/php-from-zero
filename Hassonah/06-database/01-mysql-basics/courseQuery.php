<html>
    <head>
    </head>
    <body>
<?php
// Database example
// Load file
include_once "Course.php";
require_once "config.inc.php";
$pdo = db_connect();
// get everything from catalog table
$query =
    " SELECT courseId as ID, title as Name, numOfCredits as hrs  FROM Course order by courseId";
/* Create a PDOStatement object */
// Run query
$result = $pdo->query($query);
?>
    <table border=\"0\">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title </th>
        <th>Credit Hours</th>
    </tr>
    </thead>
    <tbody>
<?php
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $course = new Course($row);
    echo $course->outputAsRow();
}
/*while ( $course = $result->fetchObject('Course') )
 echo $item->outputAsRow();*/
echo "</tbody>";
echo "</table>";
$pdo = null;
?>
</body>
</html>
