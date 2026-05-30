<?php
// Database example
/**
 * View information for a single record
 */
// Load file
include "db.inc.php";

$userid = $_GET["userid"];

if (empty($userid)) {
    error_message("Empty User ID!");
}

/*
 * Prepare PDO Object
 */
$pdo = db_connect();
if (!$pdo) {
    error_message("Empty pdo object");
}

/*
 * Get the user info from the database
 */
$query = "SELECT * FROM $user_tablename WHERE userid = '$userid'";
// Run query
$result = $pdo->query($query);

if (!$result) {
    error_message("No Results");
}
// Fetch data
$query_data = $result->fetch();

// Page layout
html_header();
echo "<h3>
     Record for User No.{$query_data["usernumber"]} - {$query_data["userid"]} ({$query_data["username"]})</h3>";
?>
<div align="center">
    <table border="1" width="90%" cellpadding="2">
        <tr>
            <th width="40%">position</th>
            <td width="60%"><?php echo $query_data["userposition"]; ?></td>
        </tr>
        <tr>
            <th width="40%">Email</th>
            <td width="60%">
                <?php echo "<a href=\"mailto:{$query_data["useremail"]}\">{$query_data["useremail"]}</a>"; ?></td>
        </tr>
        <tr>
            <th width="40%">Profile</th>
            <td width="60%"><?php echo $query_data["userprofile"]; ?></td>
        </tr>

    </table>
</div>
<?php
// Page layout
html_footer();
?>