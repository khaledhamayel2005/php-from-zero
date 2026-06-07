<?php
session_start();
require_once('dbconfig.inc.php');
require_once('Product.class.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

function start_state()
{
    // Default values for search page.
    return array(
        'name' => '',
        'max_price' => '',
        'category' => '',
        'sort_col' => 'product_id',
        'sort_dir' => 'ASC',
        'current_page' => 1,
        'per_page' => 5
    );
}

function ok_col($value)
{
    if ($value === 'product_id' || $value === 'price' || $value === 'category') {
        return $value;
    }
    return 'product_id';
}

function ok_dir($value)
{
    if ($value === 'DESC') {
        return 'DESC';
    }
    return 'ASC';
}

function ok_size($value)
{
    $number = (int)$value;
    if ($number === 5 || $number === 10 || $number === 15 || $number === 20 || $number === 0) {
        return $number;
    }
    return 5;
}

function query_text($params)
{
    $query = '';
    foreach ($params as $name => $value) {
        if ($query !== '') {
            $query .= '&';
        }
        $query .= urlencode($name) . '=' . urlencode($value);
    }
    return $query;
}

function page_a($text, $state, $page)
{
    $params = array(
        'name' => $state['name'],
        'max_price' => $state['max_price'],
        'category' => $state['category'],
        'sort_col' => $state['sort_col'],
        'sort_dir' => $state['sort_dir'],
        'page' => $page,
        'per_page' => $state['per_page']
    );
    return '<a href="products.php?' . query_text($params) . '">' . h($text) . '</a>';
}

function sort_a($text, $column, $state)
{
    $direction = 'ASC';
    if ($state['sort_col'] === $column && $state['sort_dir'] === 'ASC') {
        $direction = 'DESC';
    }
    $params = array(
        'name' => $state['name'],
        'max_price' => $state['max_price'],
        'category' => $state['category'],
        'sort_col' => $column,
        'sort_dir' => $direction,
        'page' => 1,
        'per_page' => $state['per_page']
    );
    return '<a href="products.php?' . query_text($params) . '">' . h($text) . '</a>';
}

if (isset($_GET['reset'])) {
    unset($_SESSION['product_search_state']);
    header('Location: products.php');
    exit;
}

$state = start_state();
if (isset($_SESSION['product_search_state'])) {
    // Load the last search from the session.
    $saved = $_SESSION['product_search_state'];
    if (is_array($saved)) {
        foreach ($saved as $key => $value) {
            $state[$key] = $value;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // New search from form.
    $state['name'] = trim($_POST['name']);
    $state['max_price'] = trim($_POST['max_price']);
    $state['category'] = trim($_POST['category']);
    $state['current_page'] = 1;
    if (isset($_POST['per_page'])) {
        $state['per_page'] = ok_size($_POST['per_page']);
    }
} else {
    // Use data from links like sort and next page.
    if (isset($_GET['name'])) {
        $state['name'] = trim($_GET['name']);
    }
    if (isset($_GET['max_price'])) {
        $state['max_price'] = trim($_GET['max_price']);
    }
    if (isset($_GET['category'])) {
        $state['category'] = trim($_GET['category']);
    }
    if (isset($_GET['sort_col'])) {
        $state['sort_col'] = ok_col($_GET['sort_col']);
    }
    if (isset($_GET['sort_dir'])) {
        $state['sort_dir'] = ok_dir($_GET['sort_dir']);
    }
    if (isset($_GET['page'])) {
        $state['current_page'] = (int)$_GET['page'];
        if ($state['current_page'] < 1) {
            $state['current_page'] = 1;
        }
    }
    if (isset($_GET['per_page'])) {
        $state['per_page'] = ok_size($_GET['per_page']);
    }
}

$state['sort_col'] = ok_col($state['sort_col']);
$state['sort_dir'] = ok_dir($state['sort_dir']);
$state['per_page'] = ok_size($state['per_page']);

$categorySql = 'SELECT DISTINCT category FROM products ORDER BY category ASC';
$categoryStatement = $pdo->prepare($categorySql);
$categoryStatement->execute(array());
$categories = $categoryStatement->fetchAll();

$where = array();
$params = array();

// Add filters only when the user filled them.
if ($state['name'] !== '') {
    $where[] = 'LOWER(product_name) LIKE LOWER(:name)';
    $params[':name'] = '%' . $state['name'] . '%';
}
if ($state['max_price'] !== '') {
    $where[] = 'price <= :max_price';
    $params[':max_price'] = $state['max_price'];
}
if ($state['category'] !== '') {
    $where[] = 'category = :category';
    $params[':category'] = $state['category'];
}

$whereSql = '';
if (count($where) > 0) {
    $whereSql = ' WHERE ' . implode(' AND ', $where);
}

$countSql = 'SELECT COUNT(*) AS total_count FROM products' . $whereSql;
// Count rows before paging.
$countStatement = $pdo->prepare($countSql);
$countStatement->execute($params);
$countRow = $countStatement->fetch();
$totalRecords = (int)$countRow['total_count'];

$perPage = (int)$state['per_page'];
// Calculate pages.
if ($perPage === 0) {
    $totalPages = 1;
    $offset = 0;
} else {
    $totalPages = (int)ceil($totalRecords / $perPage);
    if ($totalPages < 1) {
        $totalPages = 1;
    }
    if ($state['current_page'] > $totalPages) {
        $state['current_page'] = $totalPages;
    }
    $offset = ($state['current_page'] - 1) * $perPage;
}

$_SESSION['product_search_state'] = $state;

$sort_cols = array(
    'product_id' => 'product_id',
    'price' => 'price',
    'category' => 'category'
);

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
        FROM products' . $whereSql . '
        ORDER BY ' . $sort_cols[$state['sort_col']] . ' ' . $state['sort_dir'];

if ($perPage !== 0) {
    // Limit rows for this page only.
    $sql .= ' LIMIT :limit_value OFFSET :offset_value';
}

$productStatement = $pdo->prepare($sql);
foreach ($params as $name => $value) {
    $productStatement->bindValue($name, $value);
}
if ($perPage !== 0) {
    $productStatement->bindValue(':limit_value', $perPage, PDO::PARAM_INT);
    $productStatement->bindValue(':offset_value', $offset, PDO::PARAM_INT);
}
$productStatement->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
    <section>
        <h2>Products</h2>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['role'] === 'Employee') { ?>
            <p><a href="add.php">Add Product</a></p>
        <?php } ?>
    </section>

    <section>
        <h2>Advanced Product Search</h2>
        <form method="post" action="products.php">
            <p><label>Product Name <input type="text" name="name" placeholder="Product Name" value="<?php echo h($state['name']); ?>"></label></p>
            <p><label>Maximum Price <input type="number" step="0.01" name="max_price" placeholder="Max Price" value="<?php echo h($state['max_price']); ?>"></label></p>
            <p>
                <label>Category
                    <select name="category">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $categoryRow) { ?>
                            <option value="<?php echo h($categoryRow['category']); ?>" <?php if ($state['category'] === $categoryRow['category']) { echo 'selected'; } ?>>
                                <?php echo h($categoryRow['category']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>
            </p>
            <p>
                <label>Records Per Page
                    <select name="per_page">
                        <option value="5" <?php if ($state['per_page'] == 5) { echo 'selected'; } ?>>5</option>
                        <option value="10" <?php if ($state['per_page'] == 10) { echo 'selected'; } ?>>10</option>
                        <option value="15" <?php if ($state['per_page'] == 15) { echo 'selected'; } ?>>15</option>
                        <option value="20" <?php if ($state['per_page'] == 20) { echo 'selected'; } ?>>20</option>
                        <option value="0" <?php if ($state['per_page'] == 0) { echo 'selected'; } ?>>All</option>
                    </select>
                </label>
            </p>
            <p><input type="submit" value="Filter"> <a href="products.php?reset=1">Reset / Show All</a></p>
        </form>
    </section>

    <section>
        <h2>Products Table Result</h2>
        <p>Total Products Found: <?php echo h($totalRecords); ?></p>
        <table border="1">
            <tr>
                <th>Product Image</th>
                <th><?php echo sort_a('Product ID', 'product_id', $state); ?></th>
                <th>Product Name</th>
                <th><?php echo sort_a('Category', 'category', $state); ?></th>
                <th><?php echo sort_a('Price', 'price', $state); ?></th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php
            $foundRows = false;
            while ($product = $productStatement->fetchObject('Product')) {
                $foundRows = true;
                echo $product->displayInTable();
            }
            if (!$foundRows) {
                echo '<tr><td colspan="7">No products found.</td></tr>';
            }
            ?>
        </table>

        <nav>
            <p>
                <?php
                if ($perPage !== 0 && $state['current_page'] > 1) {
                    echo page_a('Previous', $state, $state['current_page'] - 1) . ' ';
                }
                ?>
                Page <?php echo h($state['current_page']); ?> of <?php echo h($totalPages); ?>
                <?php
                if ($perPage !== 0 && $state['current_page'] < $totalPages) {
                    echo ' ' . page_a('Next', $state, $state['current_page'] + 1);
                }
                ?>
            </p>
        </nav>
    </section>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
