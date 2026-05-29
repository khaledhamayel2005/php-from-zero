<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Checkboxes Tutorial</title>
</head>
<body>
    <h1>PHP Checkboxes</h1>
    <p>Checkboxes let the user select more than one option at the same time.</p>

    <?php
    $selectedVehicles = $_POST['vehicle'] ?? array();
    if (!is_array($selectedVehicles)) {
        $selectedVehicles = array($selectedVehicles);
    }
    ?>

    <form action="index.php" method="post">
        <label>
            <input type="checkbox" name="vehicle[]" value="Bike" <?php echo in_array('Bike', $selectedVehicles, true) ? 'checked' : ''; ?>>
            I have a bike
        </label><br>
        <label>
            <input type="checkbox" name="vehicle[]" value="Car" <?php echo in_array('Car', $selectedVehicles, true) ? 'checked' : ''; ?>>
            I have a car
        </label><br>
        <label>
            <input type="checkbox" name="vehicle[]" value="Boat" <?php echo in_array('Boat', $selectedVehicles, true) ? 'checked' : ''; ?>>
            I have a boat
        </label><br>
        <input type="submit" value="Show Selection">
    </form>

    <?php if (!empty($selectedVehicles)): ?>
        <p>You selected:</p>
        <ul>
            <?php foreach ($selectedVehicles as $vehicle): ?>
                <li><?php echo htmlspecialchars($vehicle); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No vehicles were selected.</p>
    <?php else: ?>
        <p>Submit the form to see how checkbox values are received in PHP.</p>
    <?php endif; ?>
</body>
</html>