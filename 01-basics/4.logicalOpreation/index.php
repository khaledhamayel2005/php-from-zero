<?php
// Logical operators combine true and false values.
$isLoggedIn = true;
$isAdmin = false;
$hasTicket = true;
$isStudent = false;

$andResult = $isLoggedIn && $hasTicket;
$orResult = $isAdmin || $isStudent;
$notResult = !$isAdmin;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP Logical Operations Tutorial</title>
</head>
<body>
	<h1>PHP Logical Operations</h1>
	<p>This page explains <code>&&</code>, <code>||</code>, and <code>!</code>.</p>

	<ul>
		<li><code>$isLoggedIn && $hasTicket</code> = <?php echo $andResult ? 'true' : 'false'; ?></li>
		<li><code>$isAdmin || $isStudent</code> = <?php echo $orResult ? 'true' : 'false'; ?></li>
		<li><code>!$isAdmin</code> = <?php echo $notResult ? 'true' : 'false'; ?></li>
	</ul>

	<p>Logical operators are often used in conditions such as login checks and permission checks.</p>
</body>
</html>
