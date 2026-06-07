<?php

    $title = $_GET["title"];
    $filename = $_GET["filename"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Display Photo </title>
</head>
<body>
    <figure>
        <img src="uploads/<?php echo $filename?>" alt="">

        <figcaption>
            <?php  echo $title ?>
        </figcaption>
    </figure>
</body>
</html>




