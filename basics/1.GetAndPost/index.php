<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="index.php" method="post">
        <label for="username"> username</label> <br>
        <input type="text" id="username" name="username" placeholder="Enter username"> <br>
        <label for="password"> password</label> <br>
        <input type="password" id="password" name="password" placeholder="Enter password"> <br>
        <input type="submit" value="login"> 
</form>
    


<form action="index.php" method="get">
        <label for="quantity">Quantity</label> <br>
        <input type="text" name="quantity">
        <input type="submit" value="total">
        
</form>

<form action="index.php" method="post">
        <label for="x">x:</label>
        <input type="text" id="x" name="x">
        <input type="submit" value="Calculate">

</form>
</body>
</html>


<?php
    $x = $_POST["x"];
    $result = $x * $x;
    echo "the result of {$x} * {$x} is {$result}";
    echo "";
?>
<?php
    $item = "pizza";
    $price = 10;
    $quantity = $_GET["quantity"];
    $total = $price * $quantity;
    echo "the total price for {$quantity} {$item} is {$total}";
?>

<?php
        echo ($_POST["username"]. "<br>");
        echo ($_POST["password"]);
?>

<!-- 
    $_GET 
      - Data is sent in the URL
      - Not secure for sensitive data
      - Limited data length (around 2000 characters)
      - GET requests can be cached and bookmarked
      -Better for search in the page 


    $_POST
      - Data is sent in the request body[HTTP header]
      - More secure for sensitive data
      - No data length limit (depends on server configuration)
      - POST requests are not cached and cannot be bookmarked
      -Better for login and registration forms

-->