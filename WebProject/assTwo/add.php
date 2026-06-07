<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Only logged user can reach here.
    $_SESSION['return_to'] = 'add.php';
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'Employee') {
    // Add product is only for employee.
    $_SESSION['return_to'] = 'add.php';
    header('Location: login.php');
    exit;
}

require_once('dbconfig.inc.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

function val($name)
{
    if (isset($_POST[$name])) {
        return trim($_POST[$name]);
    }
    return '';
}

function jpg_ok($field)
{
    // Check uploaded file is jpeg.
    if (!isset($_FILES[$field])) {
        return false;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    if ($_FILES[$field]['type'] !== 'image/jpeg') {
        return false;
    }
    return true;
}

$cats = array('Olive Wood', 'Keffiyeh', 'Jerusalem', 'Gaza Memory', 'Embroidery', 'Posters');
$errors = array();
$newId = '';

if ($_SESSION['role'] === 'Employee' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read add product form.
    $pname = val('product_name');
    $category = val('category');
    $price = val('price');
    $quantity = val('quantity');
    $rating = val('rating');
    $desc = val('description');
    $defNo = val('default_photo');

    if ($pname === '') {
        $errors[] = 'Product name is required.';
    }
    $cat_ok = false;
    foreach ($cats as $c) {
        if ($category === $c) {
            $cat_ok = true;
        }
    }
    if ($category === '' || !$cat_ok) {
        $errors[] = 'Category is required.';
    }
    if ($price === '' || !is_numeric($price) || (float)$price <= 0) {
        $errors[] = 'Price must be a positive value.';
    }
    if ($quantity === '' || !ctype_digit($quantity)) {
        $errors[] = 'Quantity must be a non-negative integer.';
    }
    if ($rating === '' || !ctype_digit($rating) || (int)$rating < 1 || (int)$rating > 5) {
        $errors[] = 'Rating must be between 1 and 5.';
    }
    if ($desc === '') {
        $errors[] = 'Description is required.';
    }
    if ($defNo !== '1' && $defNo !== '2' && $defNo !== '3') {
        $errors[] = 'Default photo must be selected.';
    }
    if (!jpg_ok('photo1')) {
        $errors[] = 'Photo 1 is required and must be image/jpeg.';
    }
    if (!jpg_ok('photo2')) {
        $errors[] = 'Photo 2 is required and must be image/jpeg.';
    }
    if (!jpg_ok('photo3')) {
        $errors[] = 'Photo 3 is required and must be image/jpeg.';
    }

    if (count($errors) === 0) {
        try {
            // Insert first to get the product id for image names.
            $pdo->beginTransaction();
            $sql = 'INSERT INTO products
                    (product_name, category, description, price, quantity, rating, photo1, photo2, photo3, default_photo)
                    VALUES
                    (:product_name, :category, :description, :price, :quantity, :rating, :photo1, :photo2, :photo3, :default_photo)';
            $statement = $pdo->prepare($sql);
            $statement->execute(array(
                ':product_name' => $pname,
                ':category' => $category,
                ':description' => $desc,
                ':price' => $price,
                ':quantity' => $quantity,
                ':rating' => $rating,
                ':photo1' => '',
                ':photo2' => '',
                ':photo3' => '',
                ':default_photo' => ''
            ));

            $newId = $pdo->lastInsertId();
            $photo1 = $newId . '_1.jpeg';
            $photo2 = $newId . '_2.jpeg';
            $photo3 = $newId . '_3.jpeg';
            $photos = array('1' => $photo1, '2' => $photo2, '3' => $photo3);
            $defPhoto = $photos[$defNo];

            if (!move_uploaded_file($_FILES['photo1']['tmp_name'], 'images/' . $photo1)) {
                $errors[] = 'Could not save Photo 1.';
            }
            if (!move_uploaded_file($_FILES['photo2']['tmp_name'], 'images/' . $photo2)) {
                $errors[] = 'Could not save Photo 2.';
            }
            if (!move_uploaded_file($_FILES['photo3']['tmp_name'], 'images/' . $photo3)) {
                $errors[] = 'Could not save Photo 3.';
            }

            if (count($errors) === 0) {
                $sql = 'UPDATE products
                        SET photo1 = :photo1,
                            photo2 = :photo2,
                            photo3 = :photo3,
                            default_photo = :default_photo
                        WHERE product_id = :product_id';
                $statement = $pdo->prepare($sql);
                $statement->execute(array(
                    ':photo1' => $photo1,
                    ':photo2' => $photo2,
                    ':photo3' => $photo3,
                    ':default_photo' => $defPhoto,
                    ':product_id' => $newId
                ));
                $pdo->commit();
            } else {
                $pdo->rollBack();
                $newId = '';
            }
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errors[] = 'Database error: ' . $e->getMessage();
            $newId = '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
<?php if ($newId !== '') { ?>
    <section>
        <h2>Product Inserted</h2>
        <p>New Product ID: <?php echo h($newId); ?></p>
        <p><a href="view.php?id=<?php echo h($newId); ?>">View Product</a></p>
        <p><a href="add.php">Add Another Product</a></p>
    </section>
<?php } else { ?>
    <section>
        <h2>Add New Product</h2>
        <?php if (count($errors) > 0) { ?>
            <section>
                <h3>Please fix these errors</h3>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo h($error); ?></li>
                    <?php } ?>
                </ul>
            </section>
        <?php } ?>
        <form method="post" action="add.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Product Information</legend>
                <p><label>Product Name <input type="text" name="product_name" value="<?php echo h(val('product_name')); ?>"></label></p>
                <p>
                    <label>Category
                        <select name="category">
                            <option value="">Select Category</option>
                            <?php foreach ($cats as $categoryOption) { ?>
                                <option value="<?php echo h($categoryOption); ?>" <?php if (val('category') === $categoryOption) { echo 'selected'; } ?>>
                                    <?php echo h($categoryOption); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </label>
                </p>
                <p><label>Price <input type="number" step="0.01" name="price" value="<?php echo h(val('price')); ?>"></label></p>
                <p><label>Quantity <input type="number" name="quantity" value="<?php echo h(val('quantity')); ?>"></label></p>
                <p><label>Rating <input type="number" name="rating" min="1" max="5" value="<?php echo h(val('rating')); ?>"></label></p>
                <p><label>Description<br><textarea name="description" rows="5" cols="50"><?php echo h(val('description')); ?></textarea></label></p>
            </fieldset>
            <fieldset>
                <legend>Photos</legend>
                <p><label>Photo 1 <input type="file" name="photo1" accept="image/jpeg"></label></p>
                <p><label>Photo 2 <input type="file" name="photo2" accept="image/jpeg"></label></p>
                <p><label>Photo 3 <input type="file" name="photo3" accept="image/jpeg"></label></p>
                <p>
                    Default Photo:
                    <label><input type="radio" name="default_photo" value="1" <?php if (val('default_photo') !== '2' && val('default_photo') !== '3') { echo 'checked'; } ?>> Photo 1</label>
                    <label><input type="radio" name="default_photo" value="2" <?php if (val('default_photo') === '2') { echo 'checked'; } ?>> Photo 2</label>
                    <label><input type="radio" name="default_photo" value="3" <?php if (val('default_photo') === '3') { echo 'checked'; } ?>> Photo 3</label>
                </p>
            </fieldset>
            <p><input type="submit" value="Insert"></p>
        </form>
    </section>
<?php } ?>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
