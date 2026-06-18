<?php 
require_once 'config.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' ){ 
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password=$_POST['password'];
    $email= $_POST['email'];


    $sql = "INSERT INTO users (fname, lname, email, password) VALUES (:fname, :lname, :email, :password)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['fname' => $fname, 'lname' => $lname, 'email' => $email, 'password' => $password]);

    header("Location: index.php");
   
    }

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
</head>
<body>

    <header>

        

    </header>

    <body>
    <fieldset>  
        <legend>registeration</legend>

        <form action="register.php" method="POST">

            <label for="fname"> First Name: </label>
            <input type="text" name="fname" required> <br>

            <label for="lname">Last Name</label>
            <input type="text" name="lname" required> <br>


            <label for="email">Enter Email</label>
            <input type="email" name="email" required>

            <label for="password"> Enter Your password </label>
            <input type="password" name="password" required>


            <input type="submit" name="sumbit">
        </form>
    </fieldset>

    </body>
    
</body>
</html>