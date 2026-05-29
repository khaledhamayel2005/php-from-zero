<?php
$number = $_GET["number"] ?? "";
$result = "";
$error = "";

if($number > 18){
    $result = "you are an adult";
} elseif($number > 12){
    $result = "you are a teenager";
} elseif($number > 0){
    $result = "you are a child";
} else {
    $error = "please enter a valid age";
} 

$result = "the result is: {$result}";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="index.php" method="get">
        <label for="number"> number</label>
        <input type="text" id="number" name="number" placeholder="Enter your age" value="<?php echo htmlspecialchars((string)$number); ?>">
        <input type="submit" value="check">
    </form>


    <?php if ($error !== ""): ?>
        <p><?php echo $error; ?></p>
    <?php else: ?>
        <p><?php echo $result; ?></p>
    <?php endif; ?>
</body>
</html>