<html>
<head><title> refering to an image</title>
</head>
<body>

<?php
// PHP basics example
$file = "php.jpg";
$size = getimagesize($file);
echo "<img src=\"$file\" $size[3]/><br/>\n";

echo "<pre>";
// Debug output
print_r($size);
echo "</pre>";
?>
</body>
</html>