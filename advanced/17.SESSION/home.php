<?php
// This page displays the list of uploaded files
$upload_dir = "uploads/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files Page</title>
</head>
<body>
    <h1>Uploaded Files</h1>
    <p>This page lists all files uploaded to the server.</p>

    <?php
    // Check if uploads directory exists and list files
    if (is_dir($upload_dir)) {
        $files = scandir($upload_dir);
        $files = array_diff($files, array('.', '..')); // Remove . and ..

        if (count($files) > 0) {
            echo "<ul>";
            foreach ($files as $file) {
                $file_path = $upload_dir . $file;
                echo "<li><a href='" . htmlspecialchars($file_path) . "' target='_blank'>" . htmlspecialchars($file) . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No files uploaded yet.</p>";
        }
    } else {
        echo "<p>Upload directory does not exist.</p>";
    }
    ?>

    <p><a href="index.php">Back to Upload</a></p>
</body>
</html>