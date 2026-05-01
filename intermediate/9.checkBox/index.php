<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="checkbox" name="vehicle" value="Bike"> I have a bike<br>
        <input type="checkbox" name="vehicle" value="Car"> I have a car<br>
        <input type="checkbox" name="vehicle" value="Boat"> I have a boat<br>
        <input type="submit">
    </form>
</body>
</html>

<?php
    if(isset($_POST["submit"])){
        if(isset($_POST["Bike"])){
            echo "You have a bike";
        }
        if(isset($_POST["Car"])){
            echo "You have a car";      

      
    }
        if(isset($_POST["
        "])){  
            echo "You have a boat";
        }
    }       
?>