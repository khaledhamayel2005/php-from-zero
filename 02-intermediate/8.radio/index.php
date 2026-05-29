<?php 
    $color = $_POST['color'] ?? '';
    echo $color;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="radio" name="color" value="red"> Red <br>
        <input type="radio" name="color" value="blue"> Blue <br>
        <input type="radio" name="color" value="green"> Green <br>
     </form>


</body>
</html>