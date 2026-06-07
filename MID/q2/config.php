
<?php 

try{ 
$dsn = "mysql:host=localhost;dbname=store_db;charset=utf8mb4";

$user = "exam_user";
$pass= "exam_pass";

$pdo = new PDO($dsn, $user, $pass);

$pdo -> setAttribute(PDO:: ATTR_ERRMODE,PDO:: ERRMODE_EXCEPTION);
$pdo -> setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


$sort = "name";
if(isset($_GET["sort"])){
    if($_GET["sort"] == "price"){
        $sort = "price";
    
    }elseif($_GET["sort"] == "name"){
        $sort = "name";
    }
    
}

    $sql = "SELECT name,price,stock 
            FROM products 
            WHERE stock > 0
            ORDER BY $sort";



    $stmt = $pdo -> prepare($sql);
    $stmt->execute();

    $products = $stmt->fetchAll();


}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
        <table>

            <thead>
            <tr> 
                <th><a href="?sort=name">Name</a></th>
                <th><a href="?sort=price">Price</a></th>
                <th>Stock</a></th>
            </tr>
        </thead>
        <?php 
            foreach($products as $product):
        ?>      

        <tr>

                <td><?php echo $product["name"];?></td>
                <td><?php $product["price"]; ?></td>
                <td><?php $product["stock"];?></td>
        </tr>
        <?php endforeach ?>
    
    </table>


</body>
</html>