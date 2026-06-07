<?php
session_start();
require_once('dbconfig.inc.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

function val($name)
{
    // Read value from POST form.
    if (isset($_POST[$name])) {
        return trim($_POST[$name]);
    }
    return '';
}

function new_code($pdo)
{
    // Make 10 digit user code.
    do {
        $code = (string)mt_rand(1000000000, 9999999999);
        $sql = 'SELECT user_id FROM users WHERE user_code = :code';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':code' => $code));
        $row = $statement->fetch();
    } while ($row);

    return $code;
}

function bad_email($email)
{
    if (strpos($email, '@') === false) {
        return true;
    }
    if (strpos($email, '.') === false) {
        return true;
    }
    return false;
}

$errors = array();
$successCode = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get register form values.
    $fname = val('first_name');
    $lname = val('last_name');
    $email = val('email');
    $mobile = val('mobile');
    $dob = val('date_of_birth');
    $flat = val('flat_no');
    $street = val('street');
    $city = val('city');
    $country = val('country');
    $zip = val('postal_code');
    $pass = val('password');
    $pass2 = val('confirm_password');
    $role = val('role');

    if ($role !== 'Employee') {
        $role = 'Customer';
    }

    if ($fname === '') {
        $errors[] = 'First name is required.';
    }
    if ($lname === '') {
        $errors[] = 'Last name is required.';
    }
    if ($email === '') {
        $errors[] = 'Email address is required.';
    } elseif (bad_email($email)) {
        $errors[] = 'Email address format is invalid.';
    } else {
        $sql = 'SELECT user_id FROM users WHERE email = :email';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':email' => $email));
        if ($statement->fetch()) {
            $errors[] = 'Email address already exists.';
        }
    }
    if ($mobile === '') {
        $errors[] = 'Mobile number is required.';
    }
    if ($dob === '') {
        $errors[] = 'Date of birth is required.';
    } else {
        $bt = strtotime($dob);
        if ($bt === false || date('Y-m-d', $bt) !== $dob) {
            $errors[] = 'Date of birth is invalid.';
        } elseif ($bt >= strtotime(date('Y-m-d'))) {
            $errors[] = 'Date of birth must be in the past.';
        } else {
            // Check if the user is 18 or older.
            $age = (int)date('Y') - (int)date('Y', $bt);
            $bday = date('Y') . '-' . date('m-d', $bt);
            if (strtotime($bday) > strtotime(date('Y-m-d'))) {
                $age = $age - 1;
            }
            if ($age < 18) {
                $errors[] = 'User must be at least 18 years old.';
            }
        }
    }
    if ($street === '') {
        $errors[] = 'Street name and number are required.';
    }
    if ($city === '') {
        $errors[] = 'City is required.';
    }
    if ($country === '') {
        $errors[] = 'Country is required.';
    }
    if ($zip === '') {
        $errors[] = 'Postal code is required.';
    } elseif (strlen($zip) !== 6 || !ctype_digit($zip)) {
        $errors[] = 'Postal code must contain exactly 6 digits.';
    }
    if ($pass === '') {
        $errors[] = 'Password is required.';
    }
    if ($pass2 === '') {
        $errors[] = 'Confirm password is required.';
    }
    if ($pass !== '' && $pass2 !== '' && $pass !== $pass2) {
        $errors[] = 'Password and confirm password must match.';
    }

    if (count($errors) === 0) {
        // Save new user after all checks pass.
        $successCode = new_code($pdo);
        $sql = 'INSERT INTO users
                (user_code, first_name, last_name, email, mobile, date_of_birth, flat_no, street, city, country, postal_code, password, role)
                VALUES
                (:user_code, :first_name, :last_name, :email, :mobile, :date_of_birth, :flat_no, :street, :city, :country, :postal_code, md5(:password), :role)';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            ':user_code' => $successCode,
            ':first_name' => $fname,
            ':last_name' => $lname,
            ':email' => $email,
            ':mobile' => $mobile,
            ':date_of_birth' => $dob,
            ':flat_no' => $flat,
            ':street' => $street,
            ':city' => $city,
            ':country' => $country,
            ':postal_code' => $zip,
            ':password' => $pass,
            ':role' => $role
        ));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
<?php if ($successCode !== '') { ?>
    <section>
        <h2>Registration Successful</h2>
        <p>Your generated User ID is: <?php echo h($successCode); ?></p>
        <p><a href="login.php">Login</a></p>
    </section>
<?php } else { ?>
    <section>
        <h2>User Registration</h2>
        <?php if (count($errors) > 0) { ?>
            <section>
                <h3>Please fix these errors</h3>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo h($error); ?></li>
                    <?php } ?>
                </ul>
            </section>
        <?php } ?>
        <form method="post" action="register.php">
            <fieldset>
                <legend>Personal Information</legend>
                <p><label>First Name <input type="text" name="first_name" value="<?php echo h(val('first_name')); ?>"></label></p>
                <p><label>Last Name <input type="text" name="last_name" value="<?php echo h(val('last_name')); ?>"></label></p>
                <p><label>Email Address <input type="email" name="email" value="<?php echo h(val('email')); ?>"></label></p>
                <p><label>Mobile Number <input type="text" name="mobile" value="<?php echo h(val('mobile')); ?>"></label></p>
                <p><label>Date of Birth <input type="date" name="date_of_birth" value="<?php echo h(val('date_of_birth')); ?>"></label></p>
            </fieldset>
            <fieldset>
                <legend>Address</legend>
                <p><label>Flat / Unit No <input type="text" name="flat_no" value="<?php echo h(val('flat_no')); ?>"></label></p>
                <p><label>Street Name &amp; No <input type="text" name="street" value="<?php echo h(val('street')); ?>"></label></p>
                <p><label>City <input type="text" name="city" value="<?php echo h(val('city')); ?>"></label></p>
                <p><label>Country <input type="text" name="country" value="<?php echo h(val('country')); ?>"></label></p>
                <p><label>Postal Code <input type="text" name="postal_code" value="<?php echo h(val('postal_code')); ?>"></label></p>
            </fieldset>
            <fieldset>
                <legend>Account</legend>
                <p><label>Password <input type="password" name="password"></label></p>
                <p><label>Confirm Password <input type="password" name="confirm_password"></label></p>
                <p>
                    Role:
                    <label><input type="radio" name="role" value="Customer" <?php if (val('role') !== 'Employee') { echo 'checked'; } ?>> Customer</label>
                    <label><input type="radio" name="role" value="Employee" <?php if (val('role') === 'Employee') { echo 'checked'; } ?>> Employee</label>
                </p>
            </fieldset>
            <p><input type="submit" value="Register"></p>
        </form>
    </section>
<?php } ?>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
