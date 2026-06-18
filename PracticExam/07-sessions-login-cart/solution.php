<?php
session_start();

$users = array(
    "student" => md5("1234"),
    "admin" => md5("admin"),
);

$products = array(
    "p1" => array("name" => "PHP Book", "price" => 15),
    "p2" => array("name" => "USB Drive", "price" => 8),
    "p3" => array("name" => "Notebook", "price" => 4),
);

$message = "";

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: solution.php");
    exit();
}

if (isset($_GET["clear"])) {
    $_SESSION["cart"] = array();
    header("Location: solution.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $userid = trim($_POST["userid"] ?? "");
    $password = $_POST["password"] ?? "";

    if (isset($users[$userid]) && $users[$userid] == md5($password)) {
        $_SESSION["userid"] = $userid;
        $_SESSION["cart"] = array();
        header("Location: solution.php");
        exit();
    } else {
        $message = "Invalid login.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"]) && isset($_SESSION["userid"])) {
    $productId = $_POST["product_id"] ?? "";
    $quantity = (int)($_POST["quantity"] ?? 1);

    if (isset($products[$productId]) && $quantity > 0) {
        if (!isset($_SESSION["cart"][$productId])) {
            $_SESSION["cart"][$productId] = 0;
        }
        $_SESSION["cart"][$productId] += $quantity;
        $message = "Product added.";
    }
}

$cart = $_SESSION["cart"] ?? array();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Session Cart</title>
  </head>
  <body>
    <h1>Session Cart</h1>
    <?php if ($message != ""): ?>
      <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (!isset($_SESSION["userid"])): ?>
      <form method="post" action="solution.php">
        <p>
          <label>User ID:
            <input type="text" name="userid">
          </label>
        </p>
        <p>
          <label>Password:
            <input type="password" name="password">
          </label>
        </p>
        <p><button type="submit" name="login">Login</button></p>
      </form>
      <p>Try student / 1234</p>
    <?php else: ?>
      <p>Logged in as <?php echo htmlspecialchars($_SESSION["userid"]); ?> | <a href="solution.php?logout=1">Logout</a></p>

      <h2>Add Product</h2>
      <form method="post" action="solution.php">
        <p>
          <label>Product:
            <select name="product_id">
              <?php foreach ($products as $id => $product): ?>
                <option value="<?php echo htmlspecialchars($id); ?>">
                  <?php echo htmlspecialchars($product["name"]) . " - $" . $product["price"]; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </label>
        </p>
        <p>
          <label>Quantity:
            <input type="number" name="quantity" value="1" min="1">
          </label>
        </p>
        <p><button type="submit" name="add">Add</button></p>
      </form>

      <h2>Cart</h2>
      <table border="1" cellpadding="6">
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
        </tr>
        <?php
        $grandTotal = 0;
        foreach ($cart as $id => $quantity):
            $lineTotal = $products[$id]["price"] * $quantity;
            $grandTotal += $lineTotal;
        ?>
          <tr>
            <td><?php echo htmlspecialchars($products[$id]["name"]); ?></td>
            <td><?php echo $products[$id]["price"]; ?></td>
            <td><?php echo $quantity; ?></td>
            <td><?php echo $lineTotal; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
      <p>Grand total: <?php echo $grandTotal; ?></p>
      <p><a href="solution.php?clear=1">Clear cart</a></p>
    <?php endif; ?>
  </body>
</html>

