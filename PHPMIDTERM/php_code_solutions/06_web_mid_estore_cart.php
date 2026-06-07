<?php
/*
Exam: Web Mid, eStore shopping cart
Sources:
- PHPMIDTERM/PDF/Web_mid_nc2QLqJ_cKt1uav.pdf
- PHPMIDTERM/PDF/midTermMarkingSchema_d815FUG.pdf

Question:
Create the car rental search form, then develop a simple shopping cart system.
Product data is retrieved from a MySQL database and displayed dynamically.
Products(id, name, price, desc). Database: eStore, user: admin, password:
comp@334.

This study file keeps the related code blocks together:
1. car rental search form
2. config.inc.php
3. products.php
4. cart.php
*/

/*
Question Two:
Create an HTML page for a car rental service. The form should use POST and send
data to https://ajar.com/carRent/search.php. It should include car type, price,
features, start date, end date, submit, and reset controls.
*/
function carRentalSearchFormHtml(): string
{
    return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Car Rental Service</title>
</head>
<body>
    <h1>Search for Rental Cars</h1>

    <form action="https://ajar.com/carRent/search.php" method="post">
        <label for="car-type">Car Type *</label><br>
        <select id="car-type" name="car-type" required>
            <option value="" disabled selected>Select a car type</option>
            <option value="sedan">Sedan</option>
            <option value="suv">SUV</option>
            <option value="truck">Truck</option>
        </select><br><br>

        <label for="price">Price ($50 - $500)</label><br>
        <input id="price" type="number" name="price" min="50" max="500" step="10"
            placeholder="Enter price in USD"><br><br>

        <label>Car Features</label><br>
        <input id="gps" type="checkbox" name="features[]" value="gps">
        <label for="gps">GPS</label><br>
        <input id="sunroof" type="checkbox" name="features[]" value="sunroof">
        <label for="sunroof">Sunroof</label><br>
        <input id="heated-seats" type="checkbox" name="features[]" value="heated-seats">
        <label for="heated-seats">Heated Seats</label><br><br>

        <label for="start-date">Rental Start Date</label><br>
        <input id="start-date" type="date" name="start-date"><br><br>

        <label for="end-date">Rental End Date</label><br>
        <input id="end-date" type="date" name="end-date"><br><br>

        <button type="submit">Search</button>
        <button type="reset">Reset</button>
    </form>
</body>
</html>
HTML;
}

/*
Question Part A:
Write config.inc.php to connect to the MySQL database using PDO.
*/
function estoreConnection(): PDO
{
    $dsn = 'mysql:host=localhost;dbname=eStore;charset=utf8mb4';

    return new PDO($dsn, 'admin', 'comp@334', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

/*
Question Part B:
Write products.php to fetch products and display Product ID, Product Name,
Description, Price, and an "Add to Cart" link that sends the product ID to
cart.php using GET.
*/
function renderProductsPage(PDO $pdo): void
{
    // Fetch all products from the database.
    $products = $pdo->query('SELECT id, name, price, `desc` FROM Products ORDER BY id')
        ->fetchAll();

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>Products</title></head><body>';
    echo '<h1>Available Products</h1>';
    echo '<table border="1" cellpadding="6">';
    echo '<tr><th>Product ID</th><th>Product Name</th><th>Description</th><th>Price</th><th>Action</th></tr>';

    foreach ($products as $product) {
        $id = htmlspecialchars((string) $product['id']);
        echo '<tr>';
        echo '<td>' . $id . '</td>';
        echo '<td>' . htmlspecialchars($product['name']) . '</td>';
        echo '<td>' . htmlspecialchars($product['desc']) . '</td>';
        echo '<td>' . htmlspecialchars((string) $product['price']) . '</td>';
        echo '<td><a href="cart.php?id=' . urlencode($id) . '">Add to Cart</a></td>';
        echo '</tr>';
    }

    echo '</table></body></html>';
}

/*
Question Four:
Write cart.php to use PHP sessions. Add selected products, increment quantity
for repeated items, display Product Name, Quantity, Price, Total Price, and a
Remove link. Include config.inc.php instead of rewriting the connection.
*/
function renderCartPage(PDO $pdo): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_GET['remove'])) {
        unset($_SESSION['cart'][$_GET['remove']]);
    }

    if (isset($_GET['id'])) {
        $productId = (int) $_GET['id'];
        $stmt = $pdo->prepare('SELECT id, name, price FROM Products WHERE id = :id');
        $stmt->execute(['id' => $productId]);
        $product = $stmt->fetch();

        if ($product) {
            // Store each product once and increase quantity on repeated adds.
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity']++;
            } else {
                $_SESSION['cart'][$productId] = [
                    'name' => $product['name'],
                    'price' => (float) $product['price'],
                    'quantity' => 1,
                ];
            }
        }
    }

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>Shopping Cart</title></head><body>';
    echo '<h1>Your Shopping Cart</h1>';

    if (empty($_SESSION['cart'])) {
        echo '<p>Your cart is empty.</p></body></html>';
        return;
    }

    $grandTotal = 0;

    echo '<table border="1" cellpadding="6">';
    echo '<tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total Price</th><th>Action</th></tr>';

    foreach ($_SESSION['cart'] as $productId => $product) {
        $totalPrice = $product['price'] * $product['quantity'];
        $grandTotal += $totalPrice;

        echo '<tr>';
        echo '<td>' . htmlspecialchars($product['name']) . '</td>';
        echo '<td>' . htmlspecialchars((string) $product['quantity']) . '</td>';
        echo '<td>$' . number_format((float) $product['price'], 2) . '</td>';
        echo '<td>$' . number_format((float) $totalPrice, 2) . '</td>';
        echo '<td><a href="cart.php?remove=' . urlencode((string) $productId) . '">Remove</a></td>';
        echo '</tr>';
    }

    echo '<tr><td colspan="3"><strong>Grand Total</strong></td>';
    echo '<td><strong>$' . number_format((float) $grandTotal, 2) . '</strong></td><td></td></tr>';
    echo '</table></body></html>';
}
