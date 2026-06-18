<?php 
    session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loged in</title>
</head>
<?php 
require_once 'header.php';



?>
<body>

    <h1>Welcome <?php echo htmlspecialchars(($_SESSION['fname'] ?? '') . ' ' . ($_SESSION['lname'] ?? '')); ?></h1>


    
</body>
</html>