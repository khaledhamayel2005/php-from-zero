<html>
<!-- echos.php -->
<head><title>Eco Examples code listing 12.6 in the text book</title>
</head>
<body>
<?php
// Array/form example
$id = "BZUlogo";
$firstName = "Birzeit";
$lastName = "Unversity";
echo "<img src='BZUlogo.gif' alt='" . $firstName . " " . $lastName . "' >";
echo "<br/>";
echo "<img src='$id.gif' alt='$firstName $lastName' >";
echo "<br/>";
echo "<img src=\"$id.gif\" alt=\"$firstName $lastName\" >";
echo "<br/>";
echo '<img src="' . $id . '.gif" alt="' . $firstName . " " . $lastName . '" >';
echo "<br/>";
echo '<a href="university.php?id=' .
    $id .
    '">' .
    $firstName .
    " " .
    $lastName .
    "</a>";
?>
</body>
</html>
