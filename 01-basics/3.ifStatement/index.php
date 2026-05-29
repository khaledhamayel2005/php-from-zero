<?php
// Validate the input before comparing it with numbers.
$age = filter_input(INPUT_GET, 'age', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
$message = '';

if ($age === null) {
    $message = 'Enter an age to see the result.';
} elseif ($age === false) {
    $message = 'Please enter a valid positive number.';
} elseif ($age >= 18) {
    $message = 'You are an adult.';
} elseif ($age >= 13) {
    $message = 'You are a teenager.';
} else {
    $message = 'You are a child.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP If Statement Tutorial</title>
</head>
<body>
    <h1>PHP If / Else</h1>
    <p>This example shows how PHP chooses one message based on the entered age.</p>

    <form action="index.php" method="get">
        <label for="age">Age</label>
        <input type="number" id="age" name="age" min="1" placeholder="Enter your age" value="<?php echo htmlspecialchars((string)($age ?? '')); ?>">
        <input type="submit" value="Check">
    </form>

    <p><?php echo htmlspecialchars($message); ?></p>
</body>
</html>