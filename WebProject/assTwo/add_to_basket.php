<?php
session_start();

$id = '';
if (isset($_POST['product_id'])) {
    $id = trim($_POST['product_id']);
} elseif (isset($_GET['id'])) {
    $id = trim($_GET['id']);
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Save page to return after login.
    if ($id !== '') {
        $_SESSION['return_to'] = 'add_to_basket.php?id=' . urlencode($id);
    } else {
        $_SESSION['return_to'] = 'add_to_basket.php';
    }
    header('Location: login.php');
    exit;
}

require_once('includes/dbconfig.inc.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

function get_p($pdo, $id)
{
    // Get product for basket page.
    $sql = 'SELECT product_id, product_name, price, quantity, default_photo
            FROM products
            WHERE product_id = :product_id';
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':product_id' => $id));
    return $statement->fetch();
}

$errors = array();
$product = false;

if ($_SESSION['role'] !== 'Customer') {
    $errors[] = 'Only customers can add products to the basket.';
} elseif ($id === '' || !ctype_digit($id)) {
    $errors[] = 'Product ID is missing or invalid.';
} else {
    $product = get_p($pdo, $id);
    if (!$product) {
        $errors[] = 'Product was not found.';
    }
}

if ($_SESSION['role'] === 'Customer' && $product && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add quantity to session basket.
    $qty = trim($_POST['quantity']);
    if ($qty === '' || !ctype_digit($qty) || (int)$qty <= 0) {
        $errors[] = 'Quantity must be a positive integer.';
    } else {
        $qty = (int)$qty;
        $oldQty = 0;
        if (isset($_SESSION['basket'][$product['product_id']])) {
            $oldQty = (int)$_SESSION['basket'][$product['product_id']]['quantity'];
        }
        if ($qty + $oldQty > (int)$product['quantity']) {
            $errors[] = 'Requested quantity exceeds available stock.';
        } else {
            if (!isset($_SESSION['basket'])) {
                $_SESSION['basket'] = array();
            }
            if (isset($_SESSION['basket'][$product['product_id']])) {
                $_SESSION['basket'][$product['product_id']]['quantity'] =
                    $_SESSION['basket'][$product['product_id']]['quantity'] + $qty;
            } else {
                $_SESSION['basket'][$product['product_id']] = array(
                    'product_id' => $product['product_id'],
                    'product_name' => $product['product_name'],
                    'unit_price' => $product['price'],
                    'quantity' => $qty,
                    'default_photo' => $product['default_photo']
                );
            }
            header('Location: basket.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add to Basket</title>
</head>
<body>
<?php require_once('includes/header.inc.php'); ?>
<main>
    <section>
        <h2>Add to Basket</h2>
        <?php if (count($errors) > 0) { ?>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo h($error); ?></li>
                <?php } ?>
            </ul>
            <p><a href="products.php">Back to Products</a></p>
        <?php } elseif ($product) { ?>
            <form method="post" action="add_to_basket.php">
                <input type="hidden" name="product_id" value="<?php echo h($product['product_id']); ?>">
                <fieldset>
                    <legend>Confirm Product</legend>
                    <p><label>Product ID <input type="text" value="<?php echo h($product['product_id']); ?>" disabled></label></p>
                    <p><label>Product Name <input type="text" value="<?php echo h($product['product_name']); ?>" disabled></label></p>
                    <p><label>Unit Price <input type="text" value="<?php echo h(number_format((float)$product['price'], 2)); ?>" disabled></label></p>
                    <p><label>Quantity <input type="number" name="quantity" value="1" min="1"></label></p>
                </fieldset>
                <p><input type="submit" value="Add to Basket"></p>
            </form>
        <?php } ?>
    </section>
</main>
<?php require_once('includes/footer.inc.php'); ?>
</body>
</html>
