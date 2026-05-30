<?php
// Session/cookie example
// register.php
// Load file
include_once "dbcon.inc";

function in_use($userid)
{
    global $user_tablename;

    $pdo = db_connect();
    $query = "SELECT count(*) FROM $user_tablename WHERE userid = '$userid'";
    // Run query
    $result = $pdo->query($query);
    return $result->fetchColumn();
}

function register_form()
{
    global $userposition;
    global $PHP_SELF;
    $pdo = db_connect();
    $position_array = enum_options("userposition", $pdo);
    $pdo = null;
    ?>


<CENTER><H3>Create your account!</H3></CENTER>
<FORM METHOD="POST" ACTION="<?php echo $PHP_SELF; ?>">
<INPUT TYPE="HIDDEN" NAME="action" value ="register">
  <DIV ALIGN="CENTER"><CENTER><TABLE BORDER="1" WIDTH="90%">
    <TR>
      <TH WIDTH="30%" NOWRAP>Desired ID</TH>
      <TD WIDTH="70%"><INPUT TYPE="TEXT" NAME="userid"
                             SIZE="8" MAXLENGTH="8"></TD>
    </TR>
    <TR>
      <TH WIDTH="30%" NOWRAP>Desired Password</TH>
      <TD WIDTH="70%"><INPUT TYPE="PASSWORD"
                             NAME="userpassword" SIZE="15"></TD>
    </TR>
    <TR>
      <TH WIDTH="30%" NOWRAP>Retype Password</TH>
      <TD WIDTH="70%"><INPUT TYPE="PASSWORD"
                             NAME="userpassword2" SIZE="15"></TD>
    </TR>
    <TR>
      <TH WIDTH="30%" NOWRAP>Full Name</TH>
      <TD WIDTH="70%"><INPUT TYPE="TEXT" NAME="username" SIZE="20"></TD>
    </TR>
     <TR>
      <TH WIDTH="30%" NOWRAP>Gender</TH>
      <TD WIDTH="70%"><input type="radio" name="gender" value="M"> Male
          <input type="radio" name="gender" value="F"> Female
</TD>
    </TR>
    <TR>
      <TH WIDTH="30%" NOWRAP>Position</TH>
      <TD WIDTH="70%"><SELECT NAME="userposition" SIZE="1">
<?php
for ($i = 0; $i < count($position_array); $i++) {
    if (!isset($userposition) && $i == 0) {
        echo "<OPTION SELECTED VALUE=\"" .
            $position_array[$i] .
            "\">" .
            $position_array[$i] .
            "</OPTION>\n";
    } elseif ($userposition == $position_array[$i]) {
        echo "<OPTION SELECTED VALUE=\"" .
            $position_array[$i] .
            "\">" .
            $position_array[$i] .
            "</OPTION>\n";
    } else {
        echo "<OPTION VALUE=\"" .
            $position_array[$i] .
            "\">" .
            $position_array[$i] .
            "</OPTION>\n";
    }
} ?>


      </SELECT></TD>
    </TR>
    <TR>
      <TH WIDTH="30%" NOWRAP>Email</TH>
      <TD WIDTH="70%"><INPUT TYPE="TEXT" NAME="useremail" SIZE="20"
      </TD>
    </TR>
    <TR>
      <TH WIDTH="30%" NOWRAP>Profile</TH>
      <TD WIDTH="70%"><TEXTAREA ROWS="5" COLS="40"
                                NAME="userprofile"></TEXTAREA></TD>
    </TR>
    <TR>
      <TH WIDTH="30%" COLSPAN="2" NOWRAP>
        <INPUT TYPE="SUBMIT" VALUE="Submit">
        <INPUT TYPE="RESET" VALUE="Reset"></TH>
    </TR>
  </TABLE>
  </CENTER></DIV>
</FORM>
<?php


}

function create_account()
{
    $userid = $_POST["userid"];
    $username = $_POST["username"];
    $userpassword = $_POST["userpassword"];
    $userpassword2 = $_POST["userpassword2"];
    $userposition = $_POST["userposition"];
    $useremail = $_POST["useremail"];
    $userprofile = $_POST["userprofile"];
    $usergender = $_POST["gender"];
    if (empty($userid)) {
        error_message("Enter your desired ID!");
    }
    if (empty($userpassword)) {
        error_message("Enter your desired password!");
    }
    if (strlen($userpassword) < 4) {
        error_message("Password too short!");
    }
    if (empty($userpassword2)) {
        error_message("Retype your password for verification!");
    }
    if (empty($username)) {
        error_message("Enter your full name!");
    }
    if (empty($useremail)) {
        error_message("Enter your email address!");
    }
    if (empty($userprofile)) {
        $userprofile = "No Comment.";
    }

    if ($userpassword != $userpassword2) {
        error_message("Your desired password and retyped password mismatch!");
    }

    if (in_use($userid)) {
        error_message("$userid is in use. Please choose a different ID.");
    }

    $pdo = db_connect();
    $sql =
        "INSERT INTO user (usernumber,userid,userpassword,username,userposition,useremail,userprofile,sex)VALUES(?,?,md5(?),?,?,?,?,?)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, null);
    $statement->bindValue(2, $_POST["userid"]);
    $statement->bindValue(3, $_POST["userpassword"]);
    $statement->bindValue(4, $_POST["username"]);
    $statement->bindValue(5, $_POST["userposition"]);
    $statement->bindValue(6, $_POST["useremail"]);
    $statement->bindValue(7, $_POST["userprofile"]);
    $statement->bindValue(8, $_POST["gender"]);
    $statement->execute();
    $usernumber = $pdo->lastInsertId();

    // Page layout
    html_header();
    ?>


<CENTER><H3>
<?php
echo $username; ?>, thank you for registering with us!
</H3></CENTER>

<DIV ALIGN="CENTER"><CENTER><TABLE BORDER="1" WIDTH="90%">
  <TR>
    <TH WIDTH="30%" NOWRAP>User Number</TH>
                <TD WIDTH="70%"><?php echo $usernumber; ?></TD>
  </TR>
  <TR>
    <TH WIDTH="30%" NOWRAP>Desired ID</TH>
                <TD WIDTH="70%"><?php echo $userid; ?></TD>
  </TR>
  <TR>
    <TH WIDTH="30%" NOWRAP>Desired Password</TH>
                <TD WIDTH="70%"><?php echo $userpassword; ?></TD>
  </TR>
  <TR>
    <TH WIDTH="30%" NOWRAP>Full Name</TH>
                <TD WIDTH="70%"><?php echo $username; ?></TD>
  </TR>
  <TR>
    <TH WIDTH="30%" NOWRAP>Position</TH>
                <TD WIDTH="70%"><?php echo $userposition; ?></TD>
  </TR>
  <TR>
    <TH WIDTH="30%" NOWRAP>Email</TH>
                <TD WIDTH="70%"><?php echo $useremail; ?></TD>
  </TR>
  <TR>
    <TH WIDTH="30%" NOWRAP>Profile</TH>
                <TD WIDTH="70%"><?php echo htmlspecialchars($userprofile); ?></TD>
  </TR>
</TABLE>
</CENTER></DIV>
<?php
// Page layout
html_footer();
}

if (empty($_POST)) {
    $_POST["action"] = "";
}

// Choose case
switch ($_POST["action"]) {
    // Case option
    case "register":
        create_account();
        break;
    // Case option
    default:
        // Page layout
        html_header();
        register_form();
        // Page layout
        html_footer();
        break;
}
?>
