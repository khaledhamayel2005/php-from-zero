<?php
session_start();
require_once('includes/dbconfig.inc.php');
require_once('includes/Product.class.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

$product = null;
$error = '';

if (!isset($_GET['id']) || trim($_GET['id']) === '' || !ctype_digit($_GET['id'])) {
    $error = 'Product ID is missing or invalid.';
} else {
    $sql = 'SELECT product_id AS productId,
                   product_name AS productName,
                   category,
                   description,
                   price,
                   quantity,
                   rating,
                   photo1,
                   photo2,
                   photo3,
                   default_photo AS defaultPhoto
            FROM products
            WHERE product_id = :product_id';
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':product_id' => $_GET['id']));
    $product = $statement->fetchObject('Product');
    if (!$product) {
        $error = 'The requested product was not found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Product</title>
</head>
<body>
<?php require_once('includes/header.inc.php'); ?>
<?php
if ($error !== '') {
    echo '<main><section><h2>Product Error</h2><p>' . h($error) . '</p><p><a href="products.php">Back to Products</a></p></section></main>';
} else {
    echo $product->displayProductPage();
}
?>
<?php require_once('includes/footer.inc.php'); ?>
</body>
</html>
