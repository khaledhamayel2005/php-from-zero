<?php
// Read form values safely so the page can be loaded before submitting any form.
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$quantity = $_GET['quantity'] ?? '';
$x = $_POST['x'] ?? '';

$squareResult = '';
if ($x !== '' && is_numeric($x)) {
        $squareResult = $x * $x;
}

$totalPrice = '';
if ($quantity !== '' && is_numeric($quantity)) {
        $item = 'pizza';
        $price = 10;
        $totalPrice = $price * $quantity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP GET and POST Tutorial</title>
</head>
<body>
        <h1>PHP GET and POST</h1>
        <p>This page shows the difference between <code>GET</code> and <code>POST</code> using three small examples.</p>

        <section>
                <h2>1. Login Form with POST</h2>
                <form action="index.php" method="post">
                        <label for="username">Username</label><br>
                        <input type="text" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>"><br>
                        <label for="password">Password</label><br>
                        <input type="password" id="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($password); ?>"><br>
                        <input type="submit" value="Login">
                </form>

                <?php if ($username !== '' || $password !== ''): ?>
                        <p>Username submitted: <?php echo htmlspecialchars($username); ?></p>
                        <p>Password submitted: <?php echo htmlspecialchars($password); ?></p>
                <?php else: ?>
                        <p>POST sends form data in the request body, which is why it is used for login forms.</p>
                <?php endif; ?>
        </section>

        <section>
                <h2>2. Quantity Form with GET</h2>
                <form action="index.php" method="get">
                        <label for="quantity">Quantity</label><br>
                        <input type="number" id="quantity" name="quantity" min="1" value="<?php echo htmlspecialchars((string)$quantity); ?>">
                        <input type="submit" value="Total">
                </form>

                <?php if ($totalPrice !== ''): ?>
                        <p>The total price for <?php echo htmlspecialchars((string)$quantity); ?> pizza(s) is <?php echo htmlspecialchars((string)$totalPrice); ?>.</p>
                <?php else: ?>
                        <p>GET puts the data in the URL, so it is useful for searches and simple filters.</p>
                <?php endif; ?>
        </section>

        <section>
                <h2>3. Square Calculator with POST</h2>
                <form action="index.php" method="post">
                        <label for="x">x</label><br>
                        <input type="number" id="x" name="x" value="<?php echo htmlspecialchars((string)$x); ?>">
                        <input type="submit" value="Calculate">
                </form>

                <?php if ($squareResult !== ''): ?>
                        <p>The result of <?php echo htmlspecialchars((string)$x); ?> * <?php echo htmlspecialchars((string)$x); ?> is <?php echo htmlspecialchars((string)$squareResult); ?>.</p>
                <?php else: ?>
                        <p>Enter a number to see the square calculation.</p>
                <?php endif; ?>
        </section>

        <section>
                <h2>Quick Summary</h2>
                <p><strong>GET</strong> is visible in the URL and easy to bookmark.</p>
                <p><strong>POST</strong> keeps data out of the URL and is better for sensitive data.</p>
        </section>
</body>
</html>