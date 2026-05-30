<html>
<!-- form_checker.php COMP334 -->
<head>
<title>PHP Form example</title>
<link type="text/css" rel="stylesheet" href="formstyle.css"/>
</head>
<body>

<?php
// Form example
/*declare some function*/
function print_form($f_name, $l_name, $email, $os)
{
    echo <<<EOL
        <h3>Please enter your infromation</h3>
        <p>Fields with a "<span class= "required"></span>" are required.</p>
        <form action="form_checker.php" method="POST">
        <div class="grid-container">
        <label>First Name : </label><input type="text" name="f_name" value="$f_name" />
        <label class= "required">Last Name :</label><input type="text" name="l_name" value="$l_name" />
        <label class= "required">Email Address :</label><input class ="required" type="text" name="email" value="$email" />
        Operating System: <input type="text" name="os" value="$os" />
        </div>
      <input type="submit" name="submit" value="Submit" /><input type="reset" />
     </form>

    EOL;
} //**  end of "print_from" function

function check_form($f_name, $l_name, $email, $os)
{
    if (!$l_name || !$email) {
        echo "<h3>You are missing some required fields!</h3>";
        print_form($f_name, $l_name, $email, $os);
    } else {
        confirm_form($f_name, $l_name, $email, $os);
    }
} //** end of "check_from" function

function confirm_form($f_name, $l_name, $email, $os)
{
    echo <<<EOL
    <h2>Thanks! Below is the information you have sent to us.</h2>
    <h3>Contact Info</h3>
    EOL;
    echo "Name: $f_name $l_name <br/>";
    echo "Email: $email <br/>";
    echo "OS: $os";
} //**  end of "confirm_from" function

/*Main Program*/

if (!isset($_POST["submit"])) {
    print_form("", "", "", "");
} else {
    check_form(
        $_POST["f_name"],
        $_POST["l_name"],
        $_POST["email"],
        $_POST["os"],
    );
}
?>

</body>
</html>
