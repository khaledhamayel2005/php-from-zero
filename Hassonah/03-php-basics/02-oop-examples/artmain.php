<?php
// OOP example
 // Load file
 include "artist.php"; ?>
<html>
<head>

</head>
<body>
<?php
$picasso = new Artist(
    "Pablo",
    "Picasso",
    "Malaga",
    "October 25 1881",
    "April 8 1973",
);
echo $picasso->outputAsTable();
?>
</body>
</html>