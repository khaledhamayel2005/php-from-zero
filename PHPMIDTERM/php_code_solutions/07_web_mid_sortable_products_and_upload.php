<?php
/*
Exam: Web mid
Sources:
- PHPMIDTERM/PDF/Web mid.pdf
- /home/hamail/Downloads/php code forms M.pdf

This file contains the two PHP code questions from this exam:
1. Database with sortable table.
2. Photo upload with display page.
*/

/*
Question 3:
Create a PHP script that displays products from a database in a sortable HTML
table. Database: store_db, user: exam_user, password: exam_pass.
Table: products(id, name, price, stock). Show only products where stock > 0.
Make Product Name and Price headers clickable sort links.
*/
function renderSortableProducts(): void
{
    $allowedSorts = [
        'name' => 'name',
        'price' => 'price',
    ];
    $sort = $_GET['sort'] ?? 'name';
    $orderBy = $allowedSorts[$sort] ?? 'name';

    $pdo = new PDO(
        'mysql:host=localhost;dbname=store_db;charset=utf8mb4',
        'exam_user',
        'exam_pass',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    // ORDER BY uses a whitelist, so it is safe to inject the chosen column.
    $stmt = $pdo->prepare(
        "SELECT name, price, stock
         FROM products
         WHERE stock > :stock
         ORDER BY $orderBy ASC"
    );
    $stmt->execute(['stock' => 0]);
    $products = $stmt->fetchAll();

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>Sortable Products</title></head><body>';
    echo '<table border="1" cellpadding="6">';
    echo '<tr>';
    echo '<th><a href="?sort=name">Product Name</a></th>';
    echo '<th><a href="?sort=price">Price</a></th>';
    echo '<th>Stock</th>';
    echo '</tr>';

    foreach ($products as $product) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($product['name']) . '</td>';
        echo '<td>' . htmlspecialchars((string) $product['price']) . '</td>';
        echo '<td>' . htmlspecialchars((string) $product['stock']) . '</td>';
        echo '</tr>';
    }

    echo '</table></body></html>';
}

/*
Question 4 - upload.php:
Create a script that submits to itself, accepts place title and photo, validates
jpg/jpeg/png/gif files up to 2MB, moves the file to uploads, renames it as
place_[timestamp].[extension], and redirects to display.php with filename and
title as GET parameters. If invalid, keep the form visible.
*/
function handlePhotoUpload(): void
{
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $photo = $_FILES['photo'] ?? null;
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $maxSize = 2 * 1024 * 1024;

        if ($title === '' || !$photo || $photo['error'] !== UPLOAD_ERR_OK) {
            $error = 'Please enter a title and choose a valid photo.';
        } else {
            $extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowed, true) || $photo['size'] > $maxSize) {
                $error = 'Photo must be jpg, jpeg, png, or gif and no larger than 2MB.';
            } else {
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0775, true);
                }

                $newName = 'place_' . time() . '.' . $extension;
                $target = 'uploads/' . $newName;

                if (move_uploaded_file($photo['tmp_name'], $target)) {
                    header('Location: display.php?filename=' . urlencode($newName)
                        . '&title=' . urlencode($title));
                    exit;
                }

                $error = 'Could not save the uploaded file.';
            }
        }
    }

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>Upload Photo</title></head><body>';

    if ($error !== '') {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }

    echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" enctype="multipart/form-data">';
    echo '<label>Place title: <input type="text" name="title" required></label><br>';
    echo '<label>Photo: <input type="file" name="photo" accept=".jpg,.jpeg,.png,.gif" required></label><br>';
    echo '<button type="submit">Upload</button>';
    echo '</form></body></html>';
}

/*
Question 4 - display.php:
Get filename and title from GET and display the image inside a figure element
with the title inside figcaption.
*/
function displayUploadedPhoto(): void
{
    $filename = basename($_GET['filename'] ?? '');
    $title = $_GET['title'] ?? 'Uploaded photo';
    $path = 'uploads/' . $filename;

    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<title>Display Photo</title></head><body>';

    if ($filename === '' || !is_file($path)) {
        echo '<p>Photo was not found.</p></body></html>';
        return;
    }

    echo '<figure>';
    echo '<img src="' . htmlspecialchars($path) . '" alt="' . htmlspecialchars($title) . '">';
    echo '<figcaption>' . htmlspecialchars($title) . '</figcaption>';
    echo '</figure>';
    echo '</body></html>';
}
