<?php
// Database example
// Load file
include "db.inc.php";

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "list_records";
}

// Choose case
switch ($action) {
    // Case option
    case "view_record":
        // Send header
        header("Location: userviewer.php?userid={$_GET["userid"]}");
        break;
    // Case option
    default:
        list_records();
        break;
}

// list records function
/**
 * View all records in a table
 */
function list_records()
{
    global $default_dbname, $user_tablename;
    global $records_per_page;
    $PHP_SELF = $_SERVER["PHP_SELF"];

    /*
     * Get pdo Object
     */
    $pdo = db_connect($default_dbname);
    if (!$pdo) {
        error_message("Null PDO Object");
    }

    /*
     * Prepare query
     */
    $query = "SELECT count(*) FROM $user_tablename";

    // Run query
    $result = $pdo->query($query);

    // Fetch data
    $query_data = $result->fetch();

    /*
     * Check results
     */

    if (empty($query_data) || !$query) {
        error_message("No Results");
    }

    $total_num_user = $query_data[0];
    if (!$total_num_user) {
        error_message("No User Found!");
    }

    /*
     * Pagination setup
     * Page number starts at 1
     * Offset skips old records
     */

    if (empty($_GET["next_page"])) {
        $_GET["next_page"] = 0;
    }
    $cur_page = $_GET["next_page"];
    $page_num = $cur_page + 1;
    $recordsToSkip = $cur_page * $records_per_page;
    $total_num_page = $last_page_num = ceil(
        $total_num_user / $records_per_page,
    );

    /*
     * Prepare the header
     */
    // Page layout
    html_header();

    echo "<h3 class='center'>$total_num_user users found. Displaying the page
                     $page_num out of $last_page_num.</h3>\n";

    /*
     * Set the order by and sort by
     */
    $order_by = null;
    if (isset($_GET["order_by"])) {
        $order_by = $_GET["order_by"];
    }

    /*
     * Allow only order by on a set of predefined columns
     */

    $orderByWhiteList = [
        "usernumber",
        "userpassword",
        "userid",
        "username",
        "userposition",
        "useremail",
        "userprofile",
        "sex",
    ];

    if (!in_array($order_by, $orderByWhiteList)) {
        $order_by = "userid";
    }

    $sort_order = null;
    if (isset($_GET["sort_order"])) {
        $sort_order = $_GET["sort_order"];
    }

    if ($sort_order == "ASC") {
        $sort_order = "DESC";
        $org_sort_order = "ASC";
    } else {
        $sort_order = "ASC";
        $org_sort_order = "DESC";
    }

    $limit_str = "LIMIT " . $records_per_page . " OFFSET $recordsToSkip";

    $query = "SELECT usernumber, userid, username FROM $user_tablename ORDER BY $order_by $sort_order $limit_str ";

    /*
     * Get all results
     */
    // Run query
    $result = $pdo->query($query);
    if (!$result) {
        error_message("Empty results");
    }
    ?>

    <div align="center">
        <table border="1" width="90%" cellpadding="2">
            <tr>
                <th width="25%" nowrap>
                    <!-- Set order_by to usernumber -->
                    <a href="<?php echo "$PHP_SELF?action=list_records&sort_order=$sort_order&order_by=usernumber"; ?>">
                        User Number
                    </a>
                </th>
                <th width="25%" nowrap>
                    <!-- Set order_by to userid -->
                    <a href="<?php echo "$PHP_SELF?action=list_records&sort_order=$sort_order&order_by=userid"; ?>">
                        User ID
                    </a>
                </th>
                <th width="25%" nowrap>
                    <!-- Set order_by to username -->
                    <a href="<?php echo "$PHP_SELF?action=list_records&sort_order=$sort_order&order_by=username"; ?>">
                        User Name
                    </a>
                </th>
                <th width="25%" nowrap>Action</th>
            </tr>
            <?php
            while ($query_data = $result->fetch()) {
                $usernumber = $query_data["usernumber"];
                $userid = $query_data["userid"];
                $username = $query_data["username"];
                echo "<tr>\n";
                echo "<td width=\"25%\" align=\"center\">$usernumber</td>\n";
                echo "<td width=\"25%\" align=\"center\">$userid</td>\n";
                echo "<td width=\"25%\" align=\"center\">$username</td>\n";
                echo "<td width=\"25%\" align=\"center\">
            <a href=\"$PHP_SELF?action=view_record&userid=$userid\" target =\"usrWin\">View Record</a></td>\n";
                echo "</tr>\n";
            } ?>
        </table>
    </div>
    <?php
    echo "<br>\n";
    echo "<strong class='center align-center'>";

    if ($page_num > 1) {
        $prev_page = $cur_page - 1;
        echo "<a href=\"$PHP_SELF?action=list_records&sort_order=$org_sort_order&order_by=$order_by&next_page=0\">[Top]</a>";

        echo "<a href=\"$PHP_SELF?action=list_records&sort_order=$org_sort_order&order_by=$order_by&next_page=$prev_page\">[Prev]</a> ";
    }

    if ($page_num < $total_num_page) {
        $next_page = $cur_page + 1;
        $last_page = $total_num_page - 1;

        echo "<a href=\"$PHP_SELF?action=list_records&sort_order=$org_sort_order&order_by=$order_by&next_page=$next_page\">[Next]</a> ";

        echo "<a href=\"$PHP_SELF?action=list_records&sort_order=$org_sort_order&order_by=$order_by&next_page=$last_page\">[Bottom]</a>";
    }

    echo "</strong>";

    // Page layout
    html_footer();
}
// end of list function
