<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Checkout need login.
    $_SESSION['return_to'] = 'checkout.php';
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['basket']) || !is_array($_SESSION['basket']) || count($_SESSION['basket']) === 0) {
    header('Location: basket.php');
    exit;
}

require_once('dbconfig.inc.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

function total($basket)
{
    // Calculate basket total.
    $total = 0;
    foreach ($basket as $item) {
        $total = $total + ((float)$item['unit_price'] * (int)$item['quantity']);
    }
    return $total;
}

function new_order($pdo)
{
    // Make 10 digit order number.
    do {
        $code = (string)mt_rand(1000000000, 9999999999);
        $sql = 'SELECT order_id FROM orders WHERE order_code = :code';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':code' => $code));
        $row = $statement->fetch();
    } while ($row);

    return $code;
}

$basket = $_SESSION['basket'];
$total = total($basket);
$errors = array();
$confirmed = false;
$orderNo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read dummy card data.
    $cardName = trim($_POST['cardholder']);
    $cardNo = trim($_POST['card_number']);
    $mm = trim($_POST['expiry_month']);
    $yy = trim($_POST['expiry_year']);
    $cvv = trim($_POST['cvv']);

    if ($cardName === '') {
        $errors[] = 'Cardholder name is required.';
    }
    if (strlen($cardNo) !== 16 || !ctype_digit($cardNo)) {
        $errors[] = 'Card number must contain exactly 16 digits.';
    }
    if ($mm === '' || !ctype_digit($mm) || (int)$mm < 1 || (int)$mm > 12) {
        $errors[] = 'Expiry month is invalid.';
    }
    if ($yy === '' || !ctype_digit($yy)) {
        $errors[] = 'Expiry year is invalid.';
    } elseif ((int)$yy < (int)date('Y') || (int)$yy > (int)date('Y') + 10) {
        $errors[] = 'Expiry year is invalid.';
    }
    if (strlen($cvv) !== 3 || !ctype_digit($cvv)) {
        $errors[] = 'CVV must contain exactly 3 digits.';
    }

    if (count($errors) === 0) {
        try {
            // All order queries should succeed together.
            $pdo->beginTransaction();

            foreach ($basket as $item) {
                $sql = 'SELECT quantity FROM products WHERE product_id = :product_id';
                $statement = $pdo->prepare($sql);
                $statement->execute(array(':product_id' => $item['product_id']));
                $row = $statement->fetch();
                if (!$row || (int)$row['quantity'] < (int)$item['quantity']) {
                    $errors[] = 'Not enough stock for ' . $item['product_name'] . '.';
                }
            }

            if (count($errors) === 0) {
                // Save order header.
                $orderNo = new_order($pdo);
                $sql = 'INSERT INTO orders (order_code, user_id, order_date, total_amount)
                        VALUES (:order_code, :user_id, :order_date, :total_amount)';
                $statement = $pdo->prepare($sql);
                $statement->execute(array(
                    ':order_code' => $orderNo,
                    ':user_id' => $_SESSION['user_id'],
                    ':order_date' => date('Y-m-d H:i:s'),
                    ':total_amount' => $total
                ));
                $orderId = $pdo->lastInsertId();

                foreach ($basket as $item) {
                    // Save each basket item.
                    $line = (float)$item['unit_price'] * (int)$item['quantity'];
                    $sql = 'INSERT INTO order_items
                            (order_id, product_id, product_name, unit_price, quantity, line_total)
                            VALUES
                            (:order_id, :product_id, :product_name, :unit_price, :quantity, :line_total)';
                    $statement = $pdo->prepare($sql);
                    $statement->execute(array(
                        ':order_id' => $orderId,
                        ':product_id' => $item['product_id'],
                        ':product_name' => $item['product_name'],
                        ':unit_price' => $item['unit_price'],
                        ':quantity' => $item['quantity'],
                        ':line_total' => $line
                    ));

                    $sql = 'UPDATE products
                            SET quantity = quantity - :ordered_quantity
                            WHERE product_id = :product_id';
                    $statement = $pdo->prepare($sql);
                    $statement->execute(array(
                        ':ordered_quantity' => $item['quantity'],
                        ':product_id' => $item['product_id']
                    ));
                }

                $pdo->commit();
                unset($_SESSION['basket']);
                $confirmed = true;
            } else {
                $pdo->rollBack();
            }
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errors[] = 'Order could not be placed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
<?php if ($confirmed) { ?>
    <section>
        <h2>Order Confirmation</h2>
        <p>Your 10-digit Order ID is: <?php echo h($orderNo); ?></p>
        <p>Order Total: <?php echo h(number_format($total, 2)); ?></p>
        <p><a href="products.php">Back to Products</a></p>
    </section>
<?php } else { ?>
    <section>
        <h2>Checkout</h2>
        <?php if (count($errors) > 0) { ?>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo h($error); ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <table border="1">
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Line Total</th>
            </tr>
            <?php foreach ($basket as $item) { ?>
                <?php $line = (float)$item['unit_price'] * (int)$item['quantity']; ?>
                <tr>
                    <td><img src="images/<?php echo h($item['default_photo']); ?>" alt="<?php echo h($item['product_name']); ?>" width="90" height="70"></td>
                    <td><?php echo h($item['product_name']); ?></td>
                    <td><?php echo h(number_format((float)$item['unit_price'], 2)); ?></td>
                    <td><?php echo h($item['quantity']); ?></td>
                    <td><?php echo h(number_format($line, 2)); ?></td>
                </tr>
            <?php } ?>
        </table>
        <p>Order Total: <?php echo h(number_format($total, 2)); ?></p>

        <form method="post" action="checkout.php">
            <fieldset>
                <legend>Credit Card</legend>
                <p>Use dummy test card data only: Khaled Hamayel, 9701231439000001, CVV 439.</p>
                <p><label>Cardholder Name <input type="text" name="cardholder" value="Khaled Hamayel"></label></p>
                <p><label>Card Number <input type="text" name="card_number" value="9701231439000001"></label></p>
                <p>
                    <label>Expiry Month
                        <select name="expiry_month">
                            <?php for ($month = 1; $month <= 12; $month++) { ?>
                                <?php $monthText = str_pad((string)$month, 2, '0', STR_PAD_LEFT); ?>
                                <option value="<?php echo h($monthText); ?>" <?php if ($monthText === '12') { echo 'selected'; } ?>><?php echo h($monthText); ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </p>
                <p>
                    <label>Expiry Year
                        <select name="expiry_year">
                            <?php for ($year = (int)date('Y'); $year <= (int)date('Y') + 10; $year++) { ?>
                                <option value="<?php echo h($year); ?>" <?php if ($year === (int)date('Y') + 2) { echo 'selected'; } ?>><?php echo h($year); ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </p>
                <p><label>CVV <input type="text" name="cvv" value="439"></label></p>
            </fieldset>
            <p><input type="submit" value="Place Order"></p>
        </form>
    </section>
<?php } ?>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
