<?php
$products = array(
    array("name" => "Keyboard", "category" => "accessories", "price" => 25, "quantity" => 8),
    array("name" => "Mouse", "category" => "accessories", "price" => 12, "quantity" => 15),
    array("name" => "Monitor", "category" => "screens", "price" => 160, "quantity" => 4),
    array("name" => "Laptop", "category" => "computers", "price" => 720, "quantity" => 3),
    array("name" => "USB Drive", "category" => "storage", "price" => 18, "quantity" => 20),
);

$category = $_GET["category"] ?? "all";
$minPrice = trim($_GET["min_price"] ?? "");
$filtered = array();
$totalQuantity = 0;
$totalValue = 0;

foreach ($products as $product) {
    $categoryOk = ($category == "all" || $product["category"] == $category);
    $priceOk = ($minPrice == "" || $product["price"] >= $minPrice);

    if ($categoryOk && $priceOk) {
        $filtered[] = $product;
        $totalQuantity += $product["quantity"];
        $totalValue += $product["price"] * $product["quantity"];
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Products</title>
  </head>
  <body>
    <h1>Products</h1>

    <form method="get" action="solution.php">
      <p>
        <label>Category:
          <select name="category">
            <option value="all" <?php if ($category == "all") echo "selected"; ?>>All</option>
            <option value="accessories" <?php if ($category == "accessories") echo "selected"; ?>>Accessories</option>
            <option value="screens" <?php if ($category == "screens") echo "selected"; ?>>Screens</option>
            <option value="computers" <?php if ($category == "computers") echo "selected"; ?>>Computers</option>
            <option value="storage" <?php if ($category == "storage") echo "selected"; ?>>Storage</option>
          </select>
        </label>
      </p>
      <p>
        <label>Minimum price:
          <input type="text" name="min_price" value="<?php echo htmlspecialchars($minPrice); ?>">
        </label>
      </p>
      <p><button type="submit">Search</button></p>
    </form>

    <table border="1" cellpadding="6">
      <tr>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Value</th>
      </tr>
      <?php foreach ($filtered as $product): ?>
        <tr>
          <td><?php echo htmlspecialchars($product["name"]); ?></td>
          <td><?php echo htmlspecialchars($product["category"]); ?></td>
          <td><?php echo $product["price"]; ?></td>
          <td><?php echo $product["quantity"]; ?></td>
          <td><?php echo $product["price"] * $product["quantity"]; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

    <p>Total quantity: <?php echo $totalQuantity; ?></p>
    <p>Total value: <?php echo $totalValue; ?></p>
  </body>
</html>

