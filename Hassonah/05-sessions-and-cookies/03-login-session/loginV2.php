<?php
// Session/cookie example
// Start session
session_start();
// Load file
include "dbcon.inc";
$PHP_SELF = $_SERVER["PHP_SELF"];
do_authentication();
function do_authentication()
{
    global $PHP_SELF, $user_tablename;

    if (!isset($_POST["userid"])) {
        login_form();
        // Stop script
        exit();
    } else {
        $_SESSION["userpassword"] = $_POST["userpassword"];
        $_SESSION["userid"] = $_POST["userid"];
        $userid = $_POST["userid"];
        $userpassword = $_POST["userpassword"];
        $pdo = db_connect();
        if (!$pdo) {
            error_message("Null PDO Object");
        }
        $query = "SELECT  COUNT(*) FROM $user_tablename
             WHERE userid = '$userid'
            AND userpassword = md5('$userpassword')";
        // Run query
        $result = $pdo->query($query);
        if ($result->fetchColumn() == 0) {
            unset($_SESSION["userid"]);
            unset($_SESSION["userpassword"]);
            echo "Authorization failed. " .
                "You must enter a valid userid and password combo. " .
                "Click on the following link to try again.<BR>\n";
            echo "<A HREF=\"$PHP_SELF\">Login</A><BR>";
            echo "If you're not a member yet, click on the " .
                "following link to register.<BR>\n";
            echo "<A HREF= \"register.php\">Membership</A>";
            // Stop script
            exit();
        } else {
            $_SESSION["logged_in"] = true;
            $_SESSION["visits"] = 0;
            $query = "SELECT userposition FROM $user_tablename
                             WHERE userid = '$userid'";
            // Run query
            $result = $pdo->query($query);
            // Fetch data
            $pos = $result->fetch()["userposition"];
            if ($pos == "Customer") {
                $_SESSION["type"] = 1;
            } elseif ($pos == "Programmer") {
                $_SESSION["type"] = 2;
            } else {
                $_SESSION["type"] = 3;
            }
            // Send header
            header("Location: " . $_SESSION["referrer"]);
        }
    }
}

function login_form()
{
    global $PHP_SELF; ?>
<HTML>
<HEAD>
<TITLE>Login</TITLE>
</HEAD>
<BODY>
<FORM METHOD="POST" ACTION="<?php echo "$PHP_SELF"; ?>">
   <DIV ALIGN="CENTER">
      <H3>Please log in to access the page you requested.</H3>
   <TABLE BORDER="1" WIDTH="200" CELLPADDING="2">
      <TR>
         <TH WIDTH="18%" ALIGN="RIGHT" NOWRAP>ID</TH>
         <TD WIDTH="82%" NOWRAP>
            <INPUT TYPE="TEXT" NAME="userid" SIZE="8"/>
         </TD>
      </TR>
      <TR>
         <TH WIDTH="18%" ALIGN="RIGHT" NOWRAP>Password</TH>
         <TD WIDTH="82%" NOWRAP>
            <INPUT TYPE="PASSWORD" NAME="userpassword" SIZE="8"/>
         </TD>
      </TR>
 <TR>
         <TD WIDTH="100%" COLSPAN="2" ALIGN="CENTER" NOWRAP>
            <INPUT TYPE="SUBMIT" VALUE="LOGIN" NAME="Submit"/>
         </TD>
      </TR>
   </TABLE>
   </DIV>
</FORM>
</BODY>
</HTML>
<?php


}

?>
