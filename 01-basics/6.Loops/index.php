
<?php
// Read the requested count from the query string.
$counterInput = filter_input(INPUT_GET, 'count', FILTER_VALIDATE_INT);
$counter = $counterInput !== false && $counterInput !== null ? $counterInput : 5;

// Build the loop output before rendering it inside the page.
$loopOutput = array();
for ($i = 1; $i <= $counter; $i++) {
    $loopOutput[] = $i;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Loops Tutorial</title>
</head>
<body>
    <h1>PHP Loops</h1>
    <p>This example uses a <code>for</code> loop to count from 1 to a number you choose.</p>

    <form action="index.php" method="get">
        <label for="count">Enter a number to count to:</label>
        <input type="number" id="count" name="count" min="1" value="<?php echo htmlspecialchars((string)$counter); ?>">
        <input type="submit" value="Count">
    </form>

    <h2>Output</h2>
    <p>The loop runs from 1 up to <?php echo $counter; ?>.</p>
    <pre><?php echo htmlspecialchars(implode("\n", $loopOutput)); ?></pre>
</body>
</html>