<?php
// Read the selected radio button value. Only one option can be selected.
$selectedColor = $_POST['color'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Radio Buttons Tutorial</title>
</head>
<body>
    <h1>PHP Radio Buttons</h1>
    <p>Radio buttons are used when the user must choose exactly one option.</p>

    <form action="index.php" method="post">
        <label>
            <input type="radio" name="color" value="red" <?php echo $selectedColor === 'red' ? 'checked' : ''; ?>>
            Red
        </label><br>
        <label>
            <input type="radio" name="color" value="blue" <?php echo $selectedColor === 'blue' ? 'checked' : ''; ?>>
            Blue
        </label><br>
        <label>
            <input type="radio" name="color" value="green" <?php echo $selectedColor === 'green' ? 'checked' : ''; ?>>
            Green
        </label><br>
        <input type="submit" value="Show Color">
    </form>

    <?php if ($selectedColor !== ''): ?>
        <p>You selected: <?php echo htmlspecialchars($selectedColor); ?></p>
    <?php else: ?>
        <p>Select one color and submit the form to see the result.</p>
    <?php endif; ?>


</body>
</html>