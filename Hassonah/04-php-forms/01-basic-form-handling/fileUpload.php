<html>
<head>
<title>Test File Up-load</title>
</head>
<body>
<?php
// Form example
// Check uploaded file
$archive_dir = "test_upload";
if (isset($_FILES["upload_test"])) {
    if ($_FILES["upload_test"]["error"] != UPLOAD_ERR_OK) {
        echo "Upload unsuccessful!<br>\n";
    } else {
        // Show file info
        echo "Local File: " . $_FILES["upload_test"]["tmp_name"] . "<br>\n";
        echo "Name: " . $_FILES["upload_test"]["name"] . "<br>\n";
        echo "Size: " . $_FILES["upload_test"]["size"] . "<br>\n";
        echo "Type: " . $_FILES["upload_test"]["type"] . "<br>\n";
        echo "<hr>\n";
    }
    echo "$archive_dir/" . $_FILES["upload_test"]["name"] . "<br/>";
    move_uploaded_file(
        $_FILES["upload_test"]["tmp_name"],
        "$archive_dir/" . $_FILES["upload_test"]["name"],
    );

    // Delete temp file
    // unlink($_FILES['upload_test']['tmp_name']);
}
?>

<form enctype="multipart/form-data"
                action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="1024000">
<input name="upload_test" type="file">
<input type="submit" value="test upload">
</form>
</body>
</html>

