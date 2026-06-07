<?php
session_start();

function h($value)
{
    return htmlspecialchars((string)$value);
}

if (isset($_GET['remove']) && ctype_digit($_GET['remove'])) {
    // Remove one item from basket.
    if (isset($_SESSION['basket'][$_GET['remove']])) {
        unset($_SESSION['basket'][$_GET['remove']]);
    }
    header('Location: basket.php');
    exit;
}

$basket = array();
// Basket is saved in session.
if (isset($_SESSION['basket']) && is_array($_SESSION['basket'])) {
    $basket = $_SESSION['basket'];
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Basket</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
    <section>
        <h2>Shopping Basket</h2>
        <?php if (count($basket) === 0) { ?>
            <p>Your basket is empty.</p>
            <p><a href="products.php">Back to Products</a></p>
        <?php } else { ?>
            <table border="1">
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Line Total</th>
                    <th>Remove</th>
                </tr>
                <?php foreach ($basket as $item) { ?>
                    <?php
                    $lineTotal = (float)$item['unit_price'] * (int)$item['quantity'];
                    $total = $total + $lineTotal;
                    ?>
                    <tr>
                        <td><img src="images/<?php echo h($item['default_photo']); ?>" alt="<?php echo h($item['product_name']); ?>" width="90" height="70"></td>
                        <td><?php echo h($item['product_name']); ?></td>
                        <td><?php echo h(number_format((float)$item['unit_price'], 2)); ?></td>
                        <td><?php echo h($item['quantity']); ?></td>
                        <td><?php echo h(number_format($lineTotal, 2)); ?></td>
                        <td><a href="basket.php?remove=<?php echo h($item['product_id']); ?>">Remove</a></td>
                    </tr>
                <?php } ?>
            </table>
            <p>Basket Total: <?php echo h(number_format($total, 2)); ?></p>
            <p><a href="products.php">Continue Shopping</a></p>
            <p><a href="checkout.php">Proceed to Checkout</a></p>
        <?php } ?>
    </section>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
