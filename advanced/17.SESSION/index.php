<?php
// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['uploaded_file'])) {
    $target_dir = "uploads/"; // Directory to store uploaded files
    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<p>Sorry, file already exists.</p>";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["uploaded_file"]["size"] > 5000000) {
        echo "<p>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array("jpg", "png", "jpeg", "gif", "pdf", "txt");
    if (!in_array($fileType, $allowed_types)) {
        echo "<p>Sorry, only JPG, JPEG, PNG, GIF, PDF & TXT files are allowed.</p>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<p>Sorry, your file was not uploaded.</p>";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {
            echo "<p>The file " . htmlspecialchars(basename($_FILES["uploaded_file"]["name"])) . " has been uploaded.</p>";
        } else {
            echo "<p>Sorry, there was an error uploading your file.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Page</title>
</head>
<body>
    <h1>File Upload to Server</h1>
    <p>This page allows you to upload files to the server with basic validation.</p>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="uploaded_file">Select file to upload:</label>
        <input type="file" name="uploaded_file" id="uploaded_file" required>
        <input type="submit" value="Upload File">
    </form>

    <p><a href="home.php">View Uploaded Files</a></p>
</body>
</html>