<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not login, go to login page.
    if (isset($_GET['id'])) {
        $_SESSION['return_to'] = 'edit.php?id=' . urlencode($_GET['id']);
    } else {
        $_SESSION['return_to'] = 'edit.php';
    }
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'Employee') {
    // Edit product is only for employee.
    if (isset($_GET['id'])) {
        $_SESSION['return_to'] = 'edit.php?id=' . urlencode($_GET['id']);
    } elseif (isset($_POST['product_id'])) {
        $_SESSION['return_to'] = 'edit.php?id=' . urlencode($_POST['product_id']);
    } else {
        $_SESSION['return_to'] = 'edit.php';
    }
    header('Location: login.php');
    exit;
}

require_once('dbconfig.inc.php');

function h($value)
{
    return htmlspecialchars((string)$value);
}

function get_p($pdo, $id)
{
    $sql = 'SELECT product_id,
                   product_name,
                   category,
                   description,
                   price,
                   quantity,
                   rating,
                   photo1,
                   photo2,
                   photo3,
                   default_photo
            FROM products
            WHERE product_id = :product_id';
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':product_id' => $id));
    return $statement->fetch();
}

function new_jpg($field)
{
    // Check optional new image.
    if (!isset($_FILES[$field])) {
        return false;
    }
    if ($_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
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

$errors = array();
$message = '';
$id = '';

if (isset($_POST['product_id'])) {
    $id = trim($_POST['product_id']);
} elseif (isset($_GET['id'])) {
    $id = trim($_GET['id']);
}

if ($id === '' || !ctype_digit($id)) {
    $errors[] = 'Product ID is missing or invalid.';
    $product = false;
} else {
    $product = get_p($pdo, $id);
    if (!$product) {
        $errors[] = 'Product was not found.';
    }
}

if ($_SESSION['role'] === 'Employee' && $product && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read edit form.
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    $description = trim($_POST['description']);
    $defNo = trim($_POST['default_photo']);

    if ($price === '' || !is_numeric($price) || (float)$price <= 0) {
        $errors[] = 'Price must be a positive value.';
    }
    if ($quantity === '' || !ctype_digit($quantity)) {
        $errors[] = 'Quantity must be a non-negative integer.';
    }
    if ($description === '') {
        $errors[] = 'Description is required.';
    }
    if ($defNo !== '1' && $defNo !== '2' && $defNo !== '3') {
        $errors[] = 'Default photo must be selected.';
    }

    $photo1 = $product['photo1'];
    $photo2 = $product['photo2'];
    $photo3 = $product['photo3'];
    $photoFields = array('photo1' => $photo1, 'photo2' => $photo2, 'photo3' => $photo3);

    foreach ($photoFields as $field => $currentName) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE && !new_jpg($field)) {
            $errors[] = ucfirst($field) . ' must be image/jpeg if replaced.';
        }
    }

    if (count($errors) === 0) {
        // Replace only the uploaded photos.
        if (new_jpg('photo1')) {
            move_uploaded_file($_FILES['photo1']['tmp_name'], 'images/' . $photo1);
        }
        if (new_jpg('photo2')) {
            move_uploaded_file($_FILES['photo2']['tmp_name'], 'images/' . $photo2);
        }
        if (new_jpg('photo3')) {
            move_uploaded_file($_FILES['photo3']['tmp_name'], 'images/' . $photo3);
        }

        $photos = array('1' => $photo1, '2' => $photo2, '3' => $photo3);
        $defPhoto = $photos[$defNo];

        $sql = 'UPDATE products
                SET price = :price,
                    quantity = :quantity,
                    description = :description,
                    photo1 = :photo1,
                    photo2 = :photo2,
                    photo3 = :photo3,
                    default_photo = :default_photo
                WHERE product_id = :product_id';
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            ':price' => $price,
            ':quantity' => $quantity,
            ':description' => $description,
            ':photo1' => $photo1,
            ':photo2' => $photo2,
            ':photo3' => $photo3,
            ':default_photo' => $defPhoto,
            ':product_id' => $id
        ));
        $message = 'Product updated successfully.';
        $product = get_p($pdo, $id);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>
<?php require_once('header.inc.php'); ?>
<main>
    <section>
        <h2>Edit Product</h2>
        <?php if ($message !== '') { ?>
            <p><?php echo h($message); ?></p>
        <?php } ?>
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
        <?php if ($product) { ?>
            <form method="post" action="edit.php" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo h($product['product_id']); ?>">
                <fieldset>
                    <legend>Product Information</legend>
                    <p><label>Product ID <input type="text" value="<?php echo h($product['product_id']); ?>" disabled></label></p>
                    <p><label>Product Name <input type="text" value="<?php echo h($product['product_name']); ?>" disabled></label></p>
                    <p><label>Category <input type="text" value="<?php echo h($product['category']); ?>" disabled></label></p>
                    <p><label>Rating <input type="text" value="<?php echo h($product['rating']); ?>" disabled></label></p>
                    <p><label>Price <input type="number" step="0.01" name="price" value="<?php echo h($product['price']); ?>"></label></p>
                    <p><label>Quantity <input type="number" name="quantity" value="<?php echo h($product['quantity']); ?>"></label></p>
                    <p><label>Description<br><textarea name="description" rows="5" cols="50"><?php echo h($product['description']); ?></textarea></label></p>
                </fieldset>
                <fieldset>
                    <legend>Default Photo</legend>
                    <label><input type="radio" name="default_photo" value="1" <?php if ($product['default_photo'] === $product['photo1']) { echo 'checked'; } ?>> Photo 1</label>
                    <label><input type="radio" name="default_photo" value="2" <?php if ($product['default_photo'] === $product['photo2']) { echo 'checked'; } ?>> Photo 2</label>
                    <label><input type="radio" name="default_photo" value="3" <?php if ($product['default_photo'] === $product['photo3']) { echo 'checked'; } ?>> Photo 3</label>
                </fieldset>
                <fieldset>
                    <legend>Replace Photo</legend>
                    <p><label>Replace Photo 1 <input type="file" name="photo1" accept="image/jpeg"></label></p>
                    <p><label>Replace Photo 2 <input type="file" name="photo2" accept="image/jpeg"></label></p>
                    <p><label>Replace Photo 3 <input type="file" name="photo3" accept="image/jpeg"></label></p>
                </fieldset>
                <p><input type="submit" value="Save Changes"></p>
            </form>
            <p><a href="view.php?id=<?php echo h($product['product_id']); ?>">View Product</a></p>
        <?php } ?>
    </section>
</main>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
