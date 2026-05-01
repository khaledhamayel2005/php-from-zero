<?php
$number = $_GET["number"] ?? "";
$results = [];
$error = "";

if (isset($_GET["number"])) {
    if ($number === "" || !is_numeric($number)) {
        $error = "Please enter a valid number.";
    } else {
        if (isset($_GET["round"])) {
            $results[] = "the round of {$number} is " . round($number);
        }
        if (isset($_GET["floor"])) {
            $results[] = "the floor of {$number} is " . floor($number);
        }
        if (isset($_GET["ceil"])) {
            $results[] = "the ceil of {$number} is " . ceil($number);
        }
        if (isset($_GET["abs"])) {
            $results[] = "the abs of {$number} is " . abs($number);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!--Check Box , 1. round 2. floor 3. ceil 4. abs ..etc..-->

<form action="index.php" method="get">
    <input type="checkbox" id="round" name="round" <?php echo isset($_GET["round"]) ? "checked" : ""; ?>>
    <label for="round">round</label><br>

    <input type="checkbox" id="floor" name="floor" <?php echo isset($_GET["floor"]) ? "checked" : ""; ?>>
    <label for="floor">floor</label><br>

    <input type="checkbox" id="ceil" name="ceil" <?php echo isset($_GET["ceil"]) ? "checked" : ""; ?>>
    <label for="ceil">ceil</label><br>

    <input type="checkbox" id="abs" name="abs" <?php echo isset($_GET["abs"]) ? "checked" : ""; ?>>
    <label for="abs">abs</label><br>

    <input type="text" id="number" name="number" placeholder="enter a number" value="<?php echo htmlspecialchars((string)$number); ?>">
    <input type="submit" value="Calculate">
</form>

<?php if ($error !== ""): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php foreach ($results as $line): ?>
    <?php echo $line . "<br>"; ?>
<?php endforeach; ?>
</body>
</html>