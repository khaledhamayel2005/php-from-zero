
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="index.php" method="get"> 
        <label for="count">Enter a number to count to:</label>
        <input type="text" id = "count" name="count" placeholder="Enter a number">
        <input type="submit" value="Count">
    </form>
    

</body>
</html>

<?php
    $counter = $_GET["count"] ?? 5;
    for ($i = 0; $i < $counter; $i++){
        echo $i . "<br>";
    }

?>