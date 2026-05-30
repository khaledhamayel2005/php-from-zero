<html>
<head>
<title>Example to show PHP API to inset to database</title>
</head>
<body>
<?php
// Database example
if (isset($_POST["insert"])) {
    $connectionString = "mysql:host=localhost;dbname=webTest";
    $user = "httpd";
    $password = "web";

    // Try block
    try {
        // Connect DB
        $pdo = new PDO($connectionString, $user, $password);
        $sql = "INSERT INTO catalog (Name, Price) VALUES (:name,:price) ";
        $statement = $pdo->prepare($sql);
        if ($_POST["tech"] == 1) {
            $statement->bindValue(":name", $_POST["name"]);
            $statement->bindValue(":price", $_POST["price"]);
            $done = $statement->execute();
        } else {
            $a = [":name" => $_POST["name"], ":price" => $_POST["price"]];
            $done = $statement->execute($a);
        }

        if ($done) {
            echo "Your item has been successfully inserted";
        }
    } catch (PDOException $e) {
        // Stop script
        die($e->getMessage());
    }
} else {
     ?>
<div>
  <h3>Insert new Item</h3>
        <form method ="post" action ="<?php echo $_SERVER["PHP_SELF"]; ?>">
  <label>Item Name :</label> <input type="text" name ="name"/><br/>
  <label>Item Price :</label> <input type="text" name ="price"/><br/>
  <label>Which binding technique would you use? </label> <br/>
  <input type = "radio" name = "tech" value ="1" checked> Named parameters </input><br/>
  <input type = "radio" name = "tech" value ="2"> Placeholders with Array</input><br/>
  <input type ="submit" name = "insert" vale "insert"/><br/>
</form>
</div>
<?php

}
$pdo = null;
?>
</body>
</html>
